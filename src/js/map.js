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

const map = new Map({
  container: canvas,
  style: '019d6f93-6bb9-75e4-aca3-b932b6cd672c',
  center: [122.0, 12.5],
  zoom: 4,
  minZoom: 4,
  maxZoom: 12,
  scrollZoom: false,
  navigationControl: false,
  geolocateControl: false,
});

map.addControl(new NavigationControl({ showCompass: false }), 'top-right');

map.on('load', () => {
  map.resize();

  const allProjects = [
    ...(window.projectsCompleted || []),
    ...(window.projectsOngoing   || []),
  ];

  allProjects.forEach(p => {
    if (!p.lat || !p.lng) return;

    const el = document.createElement('div');
    el.className = 'map-pin';

    new Marker({ element: el })
      .setLngLat([p.lng, p.lat])
      .addTo(map);

    el.addEventListener('click', () => {
      if (window.openProjectDetail) window.openProjectDetail(p.title);
    });
  });
});

window.addEventListener('resize', () => {
  setSize();
  map.resize();
});
