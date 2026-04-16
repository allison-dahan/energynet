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

// ── Module-level interaction state ────────────────────────────────────────────

let detectedNameKey   = null;
let regionSource      = null;
let regionSourceLayer = null;
let provinceMap       = {};   // { regionName: [project, ...] }
let activeProvince    = null;

// ── Tooltip ───────────────────────────────────────────────────────────────────

const mapWrap = canvas.parentElement;
mapWrap.style.position = 'relative';

const tooltip = document.createElement('div');
tooltip.style.cssText = [
  'position:absolute',
  'pointer-events:none',
  'z-index:10',
  'background:rgba(57,45,39,0.9)',
  'border-radius:8px',
  'padding:16px 14px',
  'font-family:"Acre",sans-serif',
  'font-weight:600',
  'font-size:16px',
  'line-height:30px',
  'letter-spacing:0.05em',
  'color:#FFFFFF',
  'white-space:nowrap',
  'display:none',
].join(';');
mapWrap.appendChild(tooltip);

// ── Click panel ───────────────────────────────────────────────────────────────

const panel = document.createElement('div');
panel.style.cssText = [
  'position:absolute',
  'z-index:20',
  'width:260px',
  'display:none',
  'box-shadow:0 4px 16px rgba(0,0,0,0.18)',
  'border-radius:8px',
  'overflow:hidden',
].join(';');
mapWrap.appendChild(panel);

function isNCR(regionName) {
  return /ncr|national capital|metro manila/i.test(regionName);
}

function buildPanelHtml(regionName, projects) {
  let bodyContent = '';

  if (isNCR(regionName)) {
    const cities = {};
    projects.forEach(p => {
      const city = (p.location || '').toUpperCase() || 'OTHER';
      if (!cities[city]) cities[city] = [];
      cities[city].push(p);
    });
    Object.entries(cities).forEach(([city, list]) => {
      bodyContent += `<div style="font-family:'Acre',sans-serif;font-weight:600;font-size:24px;color:#917B52;letter-spacing:0.05em;border-bottom:2px solid #917B52;padding-bottom:4px;margin-bottom:8px;margin-top:12px;">${city}</div>`;
      list.forEach(p => {
        bodyContent += `
          <div style="margin-bottom:12px;">
            <div style="font-family:'Acre',sans-serif;font-weight:700;font-size:16px;color:#615237;line-height:1.3;">${p.client || ''}</div>
            <div style="font-family:'Acre',sans-serif;font-weight:400;font-size:13px;color:#392D27;margin-top:2px;">• ${p.title}</div>
          </div>`;
      });
    });
  } else {
    projects.forEach(p => {
      bodyContent += `
        <div style="margin-bottom:12px;">
          <div style="font-family:'Acre',sans-serif;font-weight:700;font-size:16px;color:#615237;line-height:1.3;">${p.client || ''}</div>
          <div style="font-family:'Acre',sans-serif;font-weight:400;font-size:13px;color:#392D27;margin-top:2px;">• ${p.title}</div>
        </div>`;
    });
  }

  return `
    <div style="background:#917B52;border-radius:8px 8px 0 0;padding:14px 16px;display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
      <span style="font-family:'Acre',sans-serif;font-weight:700;font-size:18px;letter-spacing:0.05em;color:#FFFFFF;text-transform:uppercase;line-height:1.3;">${regionName}</span>
      <button class="map-panel-close" style="background:none;border:none;color:#FFFFFF;font-size:22px;cursor:pointer;padding:0;line-height:1;flex-shrink:0;margin-top:2px;">&times;</button>
    </div>
    <div style="background:#FFFFFF;padding:16px;max-height:260px;overflow-y:auto;">
      ${bodyContent}
      <div style="margin-top:8px;">
        <button class="map-panel-details" style="width:100%;background:#392D27;border:none;border-radius:8px;padding:10px;font-family:'Acre',sans-serif;font-weight:500;font-size:20px;letter-spacing:0.05em;color:#FFFFFF;cursor:pointer;">DETAILS</button>
      </div>
    </div>`;
}

function openPanel(regionName, clickX, clickY) {
  const projects = provinceMap[regionName] || [];
  panel.innerHTML = buildPanelHtml(regionName, projects);
  panel.style.display = 'block';

  // Initial position near click
  let left = clickX + 12;
  let top  = clickY - 20;
  panel.style.left = left + 'px';
  panel.style.top  = top + 'px';

  // Clamp to map bounds after render
  requestAnimationFrame(() => {
    const mw = mapWrap.offsetWidth;
    const mh = mapWrap.offsetHeight;
    const pw = panel.offsetWidth;
    const ph = panel.offsetHeight;
    if (left + pw > mw - 8) left = Math.max(8, mw - pw - 8);
    if (top  + ph > mh - 8) top  = Math.max(8, mh - ph - 8);
    if (top < 8) top = 8;
    panel.style.left = left + 'px';
    panel.style.top  = top + 'px';
  });

  panel.querySelector('.map-panel-close')?.addEventListener('click', closePanel);

  panel.querySelector('.map-panel-details')?.addEventListener('click', () => {
    if (window.openProjectsDrawer) {
      window.openProjectsDrawer();
    } else if (window.openProjectDetail && projects[0]) {
      window.openProjectDetail(projects[0].title);
    }
  });
}

function closePanel() {
  panel.style.display = 'none';
  activeProvince = null;
  if (detectedNameKey && map.getLayer('project-regions-active')) {
    map.setFilter('project-regions-active',        ['==', ['get', detectedNameKey], '']);
    map.setFilter('project-regions-active-border', ['==', ['get', detectedNameKey], '']);
  }
}

// ── Region highlighting ───────────────────────────────────────────────────────

function highlightRegions(allProjects) {
  const validProjects = allProjects.filter(p => p.lat && p.lng);
  if (!validProjects.length) return;

  let nameKey = null;
  const regionNames     = new Set();
  const regionToProjects = {};

  // Map each project (and its second location) to its region polygon
  validProjects.forEach(proj => {
    [[proj.lat, proj.lng], [proj.lat2, proj.lng2]].forEach(([lat, lng]) => {
      if (!lat || !lng) return;
      const pixel    = map.project([lng, lat]);
      const features = map.queryRenderedFeatures(pixel, { filter: ['==', '$type', 'Polygon'] });

      features.forEach(f => {
        if (!nameKey && f.properties) {
          const candidates = ['name', 'name_en', 'NAME_1', 'NAME_2', 'admin_name', 'region'];
          for (const key of candidates) {
            if (f.properties[key]) { nameKey = key; break; }
          }
          if (!nameKey) {
            for (const [k, v] of Object.entries(f.properties)) {
              if (typeof v === 'string' && v.length > 0) { nameKey = k; break; }
            }
          }
        }
        if (nameKey && f.properties?.[nameKey]) {
          const rName = f.properties[nameKey];
          regionNames.add(rName);
          if (!regionToProjects[rName]) regionToProjects[rName] = [];
          if (!regionToProjects[rName].includes(proj)) regionToProjects[rName].push(proj);
        }
      });
    });
  });

  if (!regionNames.size || !nameKey) return;

  detectedNameKey = nameKey;
  provinceMap     = regionToProjects;

  const samplePixel    = map.project([validProjects[0].lng, validProjects[0].lat]);
  const sampleFeatures = map.queryRenderedFeatures(samplePixel, { filter: ['==', '$type', 'Polygon'] });
  if (!sampleFeatures.length) return;

  regionSource      = sampleFeatures[0].source;
  regionSourceLayer = sampleFeatures[0].sourceLayer;

  const names         = [...regionNames];
  const firstSymbolId = map.getStyle().layers.find(l => l.type === 'symbol')?.id;

  // Remove stale layers
  ['project-regions-highlight', 'project-regions-borders',
   'project-regions-active', 'project-regions-active-border']
    .forEach(id => { if (map.getLayer(id)) map.removeLayer(id); });

  map.addLayer({
    id: 'project-regions-highlight',
    type: 'fill',
    source: regionSource,
    'source-layer': regionSourceLayer,
    paint: {
      'fill-color': ['match', ['get', nameKey], names, '#917B52', '#CFB27B'],
    },
  }, firstSymbolId);

  map.addLayer({
    id: 'project-regions-borders',
    type: 'line',
    source: regionSource,
    'source-layer': regionSourceLayer,
    paint: { 'line-color': '#FFF8F0' },
  }, firstSymbolId);

  // Active province layers — empty filter hides them initially
  map.addLayer({
    id: 'project-regions-active',
    type: 'fill',
    source: regionSource,
    'source-layer': regionSourceLayer,
    filter: ['==', ['get', nameKey], ''],
    paint: { 'fill-color': '#8E7444' },
  }, firstSymbolId);

  map.addLayer({
    id: 'project-regions-active-border',
    type: 'line',
    source: regionSource,
    'source-layer': regionSourceLayer,
    filter: ['==', ['get', nameKey], ''],
    paint: { 'line-color': '#615237', 'line-width': 2 },
  }, firstSymbolId);

  // ── Tooltip on hover ──────────────────────────────────────────────────────

  map.on('mousemove', 'project-regions-highlight', (e) => {
    if (panel.style.display !== 'none') return;

    const rName   = e.features?.[0]?.properties?.[nameKey];
    const list   = rName ? provinceMap[rName] : null;

    if (!rName || !list?.length) {
      tooltip.style.display = 'none';
      map.getCanvas().style.cursor = '';
      return;
    }

    map.getCanvas().style.cursor = 'pointer';
    tooltip.innerHTML = `Area: ${rName}<br>Projects: ${list.length}`;
    tooltip.style.display = 'block';

    const rect = mapWrap.getBoundingClientRect();
    tooltip.style.left = (e.originalEvent.clientX - rect.left + 14) + 'px';
    tooltip.style.top  = (e.originalEvent.clientY - rect.top  - 10) + 'px';
  });

  map.on('mouseleave', 'project-regions-highlight', () => {
    tooltip.style.display = 'none';
    map.getCanvas().style.cursor = '';
  });

  // ── Click panel ───────────────────────────────────────────────────────────

  map.on('click', 'project-regions-highlight', (e) => {
    const rName = e.features?.[0]?.properties?.[nameKey];
    if (!rName || !provinceMap[rName]?.length) return;

    tooltip.style.display = 'none';

    if (activeProvince === rName) {
      closePanel();
      return;
    }

    activeProvince = rName;
    map.setFilter('project-regions-active',        ['==', ['get', nameKey], rName]);
    map.setFilter('project-regions-active-border', ['==', ['get', nameKey], rName]);

    const rect = mapWrap.getBoundingClientRect();
    openPanel(rName, e.originalEvent.clientX - rect.left, e.originalEvent.clientY - rect.top);
  });
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

  map.once('idle', () => {
    highlightRegions(allProjects);
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
