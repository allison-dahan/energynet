import { config, Map, Marker, NavigationControl } from '@maptiler/sdk';

const canvas = document.getElementById('projects-map-canvas');
if (!canvas) throw new Error('no map canvas');

config.apiKey = import.meta.env.VITE_MAPTILER_KEY;

const isDesktop = () => window.innerWidth >= 1024;

function setSize() {
  const w = isDesktop() ? 582 : 319;
  const h = isDesktop() ? 692 : 380;
  const wrap = canvas.parentElement; // .projects-map
  wrap.style.width  = w + 'px';
  wrap.style.height = h + 'px';
  canvas.style.width  = w + 'px';
  canvas.style.height = h + 'px';
}

setSize();

const initialZoom = () => isDesktop() ? 5 : 4;

const map = new Map({
  container: canvas,
  style: '019d883c-9869-72c8-a759-408ba05bc32f',
  center: [122.0, 12.5],
  zoom: initialZoom(),
  minZoom: 4,
  maxZoom: 12,
  scrollZoom: false,
  navigationControl: false,
  geolocateControl: false,
});

map.addControl(new NavigationControl({ showCompass: false }), 'top-right');

// ── Region highlighting ───────────────────────────────────────────────────────

function highlightRegions(projects) {
  const validProjects = projects.filter(p => p.lat && p.lng);
  if (!validProjects.length) return;

  // Find the property key used for region names by sampling a project point
  let nameKey = null;
  const regionNames = new Set();

  validProjects.forEach(p => {
    const pixel = map.project([p.lng, p.lat]);
    const features = map.queryRenderedFeatures(pixel, {
      filter: ['==', '$type', 'Polygon'],
    });

    features.forEach(f => {
      // Auto-detect the name property on first hit
      if (!nameKey && f.properties) {
        const candidates = ['name', 'name_en', 'NAME_1', 'NAME_2', 'admin_name', 'region'];
        for (const key of candidates) {
          if (f.properties[key]) { nameKey = key; break; }
        }
        // Fallback: first non-empty string property
        if (!nameKey) {
          for (const [k, v] of Object.entries(f.properties)) {
            if (typeof v === 'string' && v.length > 0) { nameKey = k; break; }
          }
        }
      }
      if (nameKey && f.properties?.[nameKey]) {
        regionNames.add(f.properties[nameKey]);
      }
    });
  });

  if (!regionNames.size || !nameKey) return;

  // Find source info from a sample feature
  const samplePixel = map.project([validProjects[0].lng, validProjects[0].lat]);
  const sampleFeatures = map.queryRenderedFeatures(samplePixel, {
    filter: ['==', '$type', 'Polygon'],
  });
  if (!sampleFeatures.length) return;

  const { source, sourceLayer } = sampleFeatures[0];
  const names = [...regionNames];

  // Insert before the first symbol layer so pins/labels stay on top
  const firstSymbolId = map.getStyle().layers.find(l => l.type === 'symbol')?.id;

  // Remove stale layer if re-running
  if (map.getLayer('project-regions-highlight')) {
    map.removeLayer('project-regions-highlight');
  }

  if (map.getLayer('project-regions-highlight')) map.removeLayer('project-regions-highlight');
  if (map.getLayer('project-regions-borders')) map.removeLayer('project-regions-borders');

  map.addLayer(
    {
      id: 'project-regions-highlight',
      type: 'fill',
      source,
      'source-layer': sourceLayer,
      paint: {
        'fill-color': [
          'match', ['get', nameKey],
          names, '#917B52',
          '#CFB27B',
        ],
      },
    },
    firstSymbolId,
  );

  map.addLayer(
    {
      id: 'project-regions-borders',
      type: 'line',
      source,
      'source-layer': sourceLayer,
      paint: {
        'line-color': '#FFF8F0'
      },
    },
    firstSymbolId,
  );
}

// ── Map init ──────────────────────────────────────────────────────────────────

map.on('load', () => {
  map.resize();

  const allProjects = [
    ...(window.projectsCompleted || []),
    ...(window.projectsOngoing   || []),
  ];

  // Add pin markers (primary + optional second location)
  allProjects.forEach(p => {
    [[p.lat, p.lng], [p.lat2, p.lng2]].forEach(([lat, lng]) => {
      if (!lat || !lng) return;

      const el = document.createElement('div');
      el.className = 'map-pin';

      new Marker({ element: el })
        .setLngLat([lng, lat])
        .addTo(map);

      el.addEventListener('click', () => {
        if (window.openProjectDetail) window.openProjectDetail(p.title);
      });
    });
  });

  // Build a flat list including second locations for region highlighting
  const allPoints = allProjects.flatMap(p => {
    const pts = [p];
    if (p.lat2 && p.lng2) pts.push({ lat: p.lat2, lng: p.lng2 });
    return pts;
  });

  // Wait for tiles to fully render before querying polygon features
  map.once('idle', () => {
    highlightRegions(allPoints);
  });
});

let lastDesktop = isDesktop();
window.addEventListener('resize', () => {
  setSize();
  map.resize();
  const nowDesktop = isDesktop();
  if (nowDesktop !== lastDesktop) {
    map.setZoom(initialZoom());
    lastDesktop = nowDesktop;
  }
});
