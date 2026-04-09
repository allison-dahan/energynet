import { config, Map, Marker, NavigationControl } from '@maptiler/sdk';

const canvas = document.getElementById('projects-map-canvas');

if (canvas) {
  config.apiKey = import.meta.env.VITE_MAPTILER_KEY;

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
}
