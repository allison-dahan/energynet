import { config, Map, Marker } from '@maptiler/sdk';

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

// ── Module-level interaction state ────────────────────────────────────────────

let detectedNameKey   = null;
let regionSource      = null;
let regionSourceLayer = null;
let provinceMap       = {};   // { regionName: [project, ...] }
let activeProvince    = null;

// ── Tooltip ───────────────────────────────────────────────────────────────────

const mapWrap = canvas.parentElement;
mapWrap.style.position = 'relative';

// ── Custom zoom buttons ───────────────────────────────────────────────────────

const btnBase = [
  'position:absolute',
  'right:-23px',
  'width:46px',
  'height:46px',
  'background:none',
  'border:none',
  'padding:0',
  'cursor:pointer',
  'z-index:10',
  'display:block',
].join(';');

const zoomInBtn = document.createElement('button');
zoomInBtn.setAttribute('aria-label', 'Zoom in');
zoomInBtn.style.cssText = btnBase + ';top:calc(50% - 50px);';
zoomInBtn.innerHTML = `<svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#zi_shadow)"><rect x="3.8136" y="3.8136" width="38.1356" height="38.1356" rx="10.1695" fill="white"/></g><path fill-rule="evenodd" clip-rule="evenodd" d="M20.9746 12.394C19.8478 12.394 18.732 12.616 17.691 13.0472C16.6499 13.4784 15.704 14.1104 14.9073 14.9072C14.1105 15.704 13.4784 16.6499 13.0472 17.6909C12.616 18.732 12.3941 19.8477 12.3941 20.9746C12.3941 22.1014 12.616 23.2171 13.0472 24.2582C13.4784 25.2992 14.1105 26.2451 14.9073 27.0419C15.704 27.8387 16.6499 28.4707 17.691 28.9019C18.732 29.3331 19.8478 29.5551 20.9746 29.5551C23.2503 29.5551 25.4328 28.651 27.0419 27.0419C28.6511 25.4327 29.5551 23.2502 29.5551 20.9746C29.5551 18.6989 28.6511 16.5164 27.0419 14.9072C25.4328 13.2981 23.2503 12.394 20.9746 12.394ZM10.4873 20.9746C10.4875 19.2904 10.8934 17.631 11.6705 16.1368C12.4477 14.6426 13.5732 13.3576 14.952 12.3904C16.3308 11.4232 17.9223 10.8023 19.5917 10.5802C21.2612 10.3581 22.9597 10.5414 24.5434 11.1145C26.127 11.6877 27.5494 12.6338 28.6901 13.8728C29.8308 15.1119 30.6563 16.6075 31.0968 18.2331C31.5373 19.8586 31.5798 21.5664 31.2208 23.2119C30.8617 24.8573 30.1116 26.3921 29.0339 27.6864L34.9958 33.6483C35.0895 33.7356 35.1646 33.8408 35.2167 33.9578C35.2688 34.0747 35.2968 34.201 35.2991 34.329C35.3013 34.457 35.2778 34.5841 35.2298 34.7029C35.1819 34.8216 35.1105 34.9294 35.02 35.0199C34.9294 35.1105 34.8216 35.1818 34.7029 35.2298C34.5842 35.2777 34.457 35.3013 34.329 35.299C34.201 35.2968 34.0748 35.2688 33.9578 35.2166C33.8409 35.1645 33.7356 35.0894 33.6483 34.9957L27.6865 29.0339C26.155 30.3095 24.2917 31.1223 22.3148 31.377C20.338 31.6317 18.3295 31.3178 16.5247 30.4721C14.7198 29.6264 13.1934 28.2838 12.1241 26.6018C11.0549 24.9197 10.4871 22.9677 10.4873 20.9746ZM20.9746 16.2076C21.2274 16.2076 21.4699 16.3081 21.6487 16.4868C21.8275 16.6656 21.928 16.9081 21.928 17.161V20.0212H24.7882C25.041 20.0212 25.2835 20.1216 25.4623 20.3004C25.6411 20.4792 25.7415 20.7217 25.7415 20.9746C25.7415 21.2274 25.6411 21.4699 25.4623 21.6487C25.2835 21.8275 25.041 21.9279 24.7882 21.9279H21.928V24.7881C21.928 25.041 21.8275 25.2835 21.6487 25.4623C21.4699 25.6411 21.2274 25.7415 20.9746 25.7415C20.7217 25.7415 20.4792 25.6411 20.3004 25.4623C20.1216 25.2835 20.0212 25.041 20.0212 24.7881V21.9279H17.161C16.9082 21.9279 16.6657 21.8275 16.4869 21.6487C16.3081 21.4699 16.2076 21.2274 16.2076 20.9746C16.2076 20.7217 16.3081 20.4792 16.4869 20.3004C16.6657 20.1216 16.9082 20.0212 17.161 20.0212H20.0212V17.161C20.0212 16.9081 20.1216 16.6656 20.3004 16.4868C20.4792 16.3081 20.7217 16.2076 20.9746 16.2076Z" fill="#917B52"/><defs><filter id="zi_shadow" x="3.92199e-05" y="3.92199e-05" width="45.7627" height="45.7627" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feMorphology radius="1.27119" operator="dilate" in="SourceAlpha" result="effect1_dropShadow_374_1715"/><feOffset/><feGaussianBlur stdDeviation="1.27119"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0.568627 0 0 0 0 0.482353 0 0 0 0 0.321569 0 0 0 0.25 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_374_1715"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_374_1715" result="shape"/></filter></defs></svg>`;

const zoomOutBtn = document.createElement('button');
zoomOutBtn.setAttribute('aria-label', 'Zoom out');
zoomOutBtn.style.cssText = btnBase + ';top:calc(50% + 4px);';
zoomOutBtn.innerHTML = `<svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#zo_shadow)"><rect x="3.8136" y="3.8136" width="38.1356" height="38.1356" rx="10.1695" fill="white"/></g><path d="M34.322 34.3222L27.7157 27.7158M27.7157 27.7158C29.5037 25.9278 30.5082 23.5027 30.5082 20.9741C30.5082 18.4454 29.5037 16.0204 27.7157 14.2323C25.9277 12.4443 23.5026 11.4398 20.974 11.4398C18.4453 11.4398 16.0202 12.4443 14.2322 14.2323C12.4442 16.0204 11.4397 18.4454 11.4397 20.9741C11.4397 23.5027 12.4442 25.9278 14.2322 27.7158C16.0202 29.5038 18.4453 30.5083 20.974 30.5083C23.5026 30.5083 25.9277 29.5038 27.7157 27.7158ZM24.7881 20.9747H17.161" stroke="#917B52" stroke-width="1.90678" stroke-linecap="round" stroke-linejoin="round"/><defs><filter id="zo_shadow" x="3.92199e-05" y="3.92199e-05" width="45.7627" height="45.7627" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feMorphology radius="1.27119" operator="dilate" in="SourceAlpha" result="effect1_dropShadow_374_1714"/><feOffset/><feGaussianBlur stdDeviation="1.27119"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0.568627 0 0 0 0 0.482353 0 0 0 0 0.321569 0 0 0 0.25 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_374_1714"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_374_1714" result="shape"/></filter></defs></svg>`;

mapWrap.appendChild(zoomInBtn);
mapWrap.appendChild(zoomOutBtn);

zoomInBtn.addEventListener('click',  () => map.zoomIn());
zoomOutBtn.addEventListener('click', () => map.zoomOut());

// ── Tooltip ───────────────────────────────────────────────────────────────────

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
  'width:max-content',
  'max-width:calc(100% - 20px)',
  'display:none',
  'box-shadow:0 4px 16px rgba(0,0,0,0.18)',
  'border-radius:8px',
  'overflow:hidden',
].join(';');
mapWrap.appendChild(panel);

// ── Philippine province → region lookup ───────────────────────────────────────

const PH_PROVINCE_TO_REGION = {
  // NCR
  'caloocan':'NATIONAL CAPITAL REGION (NCR)', 'las piñas':'NATIONAL CAPITAL REGION (NCR)',
  'las pinas':'NATIONAL CAPITAL REGION (NCR)', 'makati':'NATIONAL CAPITAL REGION (NCR)',
  'malabon':'NATIONAL CAPITAL REGION (NCR)', 'mandaluyong':'NATIONAL CAPITAL REGION (NCR)',
  'manila':'NATIONAL CAPITAL REGION (NCR)', 'marikina':'NATIONAL CAPITAL REGION (NCR)',
  'muntinlupa':'NATIONAL CAPITAL REGION (NCR)', 'navotas':'NATIONAL CAPITAL REGION (NCR)',
  'parañaque':'NATIONAL CAPITAL REGION (NCR)', 'paranaque':'NATIONAL CAPITAL REGION (NCR)',
  'pasay':'NATIONAL CAPITAL REGION (NCR)', 'pasig':'NATIONAL CAPITAL REGION (NCR)',
  'pateros':'NATIONAL CAPITAL REGION (NCR)', 'quezon city':'NATIONAL CAPITAL REGION (NCR)',
  'san juan':'NATIONAL CAPITAL REGION (NCR)', 'taguig':'NATIONAL CAPITAL REGION (NCR)',
  'valenzuela':'NATIONAL CAPITAL REGION (NCR)',
  // Region I
  'ilocos norte':'REGION I (ILOCOS REGION)', 'ilocos sur':'REGION I (ILOCOS REGION)',
  'la union':'REGION I (ILOCOS REGION)', 'pangasinan':'REGION I (ILOCOS REGION)',
  // Region II
  'batanes':'REGION II (CAGAYAN VALLEY)', 'cagayan':'REGION II (CAGAYAN VALLEY)',
  'isabela':'REGION II (CAGAYAN VALLEY)', 'nueva vizcaya':'REGION II (CAGAYAN VALLEY)',
  'quirino':'REGION II (CAGAYAN VALLEY)',
  // Region III
  'aurora':'REGION III (CENTRAL LUZON)', 'bataan':'REGION III (CENTRAL LUZON)',
  'bulacan':'REGION III (CENTRAL LUZON)', 'nueva ecija':'REGION III (CENTRAL LUZON)',
  'pampanga':'REGION III (CENTRAL LUZON)', 'tarlac':'REGION III (CENTRAL LUZON)',
  'zambales':'REGION III (CENTRAL LUZON)',
  // Region IV-A
  'batangas':'REGION IV-A (CALABARZON)', 'cavite':'REGION IV-A (CALABARZON)',
  'laguna':'REGION IV-A (CALABARZON)', 'quezon':'REGION IV-A (CALABARZON)',
  'rizal':'REGION IV-A (CALABARZON)',
  // Region IV-B
  'marinduque':'REGION IV-B (MIMAROPA)', 'occidental mindoro':'REGION IV-B (MIMAROPA)',
  'oriental mindoro':'REGION IV-B (MIMAROPA)', 'palawan':'REGION IV-B (MIMAROPA)',
  'romblon':'REGION IV-B (MIMAROPA)',
  // Region V
  'albay':'REGION V (BICOL REGION)', 'camarines norte':'REGION V (BICOL REGION)',
  'camarines sur':'REGION V (BICOL REGION)', 'catanduanes':'REGION V (BICOL REGION)',
  'masbate':'REGION V (BICOL REGION)', 'sorsogon':'REGION V (BICOL REGION)',
  // Region VI
  'aklan':'REGION VI (WESTERN VISAYAS)', 'antique':'REGION VI (WESTERN VISAYAS)',
  'capiz':'REGION VI (WESTERN VISAYAS)', 'guimaras':'REGION VI (WESTERN VISAYAS)',
  'iloilo':'REGION VI (WESTERN VISAYAS)', 'negros occidental':'REGION VI (WESTERN VISAYAS)',
  // Region VII
  'bohol':'REGION VII (CENTRAL VISAYAS)', 'cebu':'REGION VII (CENTRAL VISAYAS)',
  'negros oriental':'REGION VII (CENTRAL VISAYAS)', 'siquijor':'REGION VII (CENTRAL VISAYAS)',
  // Region VIII
  'biliran':'REGION VIII (EASTERN VISAYAS)', 'eastern samar':'REGION VIII (EASTERN VISAYAS)',
  'leyte':'REGION VIII (EASTERN VISAYAS)', 'northern samar':'REGION VIII (EASTERN VISAYAS)',
  'samar':'REGION VIII (EASTERN VISAYAS)', 'southern leyte':'REGION VIII (EASTERN VISAYAS)',
  'western samar':'REGION VIII (EASTERN VISAYAS)',
  // Region IX
  'zamboanga del norte':'REGION IX (ZAMBOANGA PENINSULA)',
  'zamboanga del sur':'REGION IX (ZAMBOANGA PENINSULA)',
  'zamboanga sibugay':'REGION IX (ZAMBOANGA PENINSULA)',
  // Region X
  'bukidnon':'REGION X (NORTHERN MINDANAO)', 'camiguin':'REGION X (NORTHERN MINDANAO)',
  'lanao del norte':'REGION X (NORTHERN MINDANAO)',
  'misamis occidental':'REGION X (NORTHERN MINDANAO)',
  'misamis oriental':'REGION X (NORTHERN MINDANAO)',
  // Region XI
  'compostela valley':'REGION XI (DAVAO REGION)', 'davao de oro':'REGION XI (DAVAO REGION)',
  'davao del norte':'REGION XI (DAVAO REGION)', 'davao del sur':'REGION XI (DAVAO REGION)',
  'davao occidental':'REGION XI (DAVAO REGION)', 'davao oriental':'REGION XI (DAVAO REGION)',
  // Region XII
  'cotabato':'REGION XII (SOCCSKSARGEN)', 'north cotabato':'REGION XII (SOCCSKSARGEN)',
  'sarangani':'REGION XII (SOCCSKSARGEN)', 'south cotabato':'REGION XII (SOCCSKSARGEN)',
  'sultan kudarat':'REGION XII (SOCCSKSARGEN)',
  // Region XIII
  'agusan del norte':'REGION XIII (CARAGA)', 'agusan del sur':'REGION XIII (CARAGA)',
  'dinagat islands':'REGION XIII (CARAGA)', 'surigao del norte':'REGION XIII (CARAGA)',
  'surigao del sur':'REGION XIII (CARAGA)',
  // CAR
  'abra':'CORDILLERA ADMINISTRATIVE REGION (CAR)', 'apayao':'CORDILLERA ADMINISTRATIVE REGION (CAR)',
  'benguet':'CORDILLERA ADMINISTRATIVE REGION (CAR)', 'ifugao':'CORDILLERA ADMINISTRATIVE REGION (CAR)',
  'kalinga':'CORDILLERA ADMINISTRATIVE REGION (CAR)',
  'mountain province':'CORDILLERA ADMINISTRATIVE REGION (CAR)',
  // BARMM
  'basilan':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
  'lanao del sur':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
  'maguindanao':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
  'maguindanao del norte':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
  'maguindanao del sur':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
  'sulu':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
  'tawi-tawi':'BANGSAMORO AUTONOMOUS REGION (BARMM)',
};

function getRegionForProvince(provinceName) {
  const key = provinceName.toLowerCase().trim();
  if (PH_PROVINCE_TO_REGION[key]) return PH_PROVINCE_TO_REGION[key];
  // Partial match fallback
  for (const [k, v] of Object.entries(PH_PROVINCE_TO_REGION)) {
    if (key.includes(k) || k.includes(key)) return v;
  }
  return provinceName.toUpperCase();
}

function buildPanelHtml(regionName, projects) {
  let bodyContent = '';
  projects.forEach(p => {
    bodyContent += `
      <div style="margin-bottom:12px;">
        <div style="font-family:'Acre',sans-serif;font-weight:700;font-size:16px;color:#615237;line-height:1.3;">${p.client || ''}</div>
        <div style="font-family:'Acre',sans-serif;font-weight:400;font-size:13px;color:#392D27;margin-top:2px;">• ${p.title}</div>
      </div>`;
  });

  return `
    <div style="background:#917B52;border-radius:8px 8px 0 0;padding:8px 10px;display:flex;align-items:center;justify-content:space-between;gap:16px;">
      <span style="font-family:'Acre',sans-serif;font-weight:700;font-size:18px;letter-spacing:0.05em;color:#FFFFFF;text-transform:uppercase;line-height:1.3;white-space:nowrap;flex:1;">${regionName}</span>
      <button class="map-panel-close" style="background:none;border:none;color:#FFFFFF;font-size:33.78px;cursor:pointer;padding:0;line-height:1;flex-shrink:0;">&times;</button>
    </div>
    <div style="background:#FFFFFF;padding:16px;max-height:260px;overflow-y:auto;">
      ${bodyContent}
      <div style="margin-top:8px;">
        <button class="map-panel-details" style="width:80px;height:35px;background:#392D27;border:none;border-radius:8px;padding:0;font-family:'Acre',sans-serif;font-weight:500;font-size:15px;letter-spacing:0.05em;color:#FFFFFF;cursor:pointer;display:block;">DETAILS</button>
      </div>
    </div>`;
}

function openPanel(provinceName) {
  const projects   = provinceMap[provinceName] || [];
  const regionName = getRegionForProvince(provinceName);
  panel.innerHTML = buildPanelHtml(regionName, projects);
  panel.style.display = 'block';

  panel.style.left = '10px';
  panel.style.top  = '10px';

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

    openPanel(rName);
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
      el.innerHTML = `<svg width="87" height="128" viewBox="0 0 87 128" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="43.5" cy="115.583" rx="43.5" ry="12.0833" fill="#392D27" fill-opacity="0.5" style="mix-blend-mode:multiply"/><path d="M43.5002 1C57.4045 1.00018 68.6663 12.2627 68.6663 26.167C68.6661 37.6077 60.9755 47.1724 50.5413 50.2461V86.8193L50.4358 87.0303L44.3948 99.1143L43.5002 100.902L42.6057 99.1143L36.4583 86.8193V50.2461C26.0241 47.1723 18.3334 37.6075 18.3333 26.167C18.3333 12.2626 29.5959 1 43.5002 1ZM43.5002 15.083C37.4067 15.083 32.4163 20.0734 32.4163 26.167C32.4164 32.2604 37.4068 37.25 43.5002 37.25C49.5935 37.2498 54.5831 32.2603 54.5833 26.167C54.5833 20.0736 49.5936 15.0832 43.5002 15.083Z" fill="#F6FAF9" stroke="#392D27" stroke-width="2"/></svg>`;

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
