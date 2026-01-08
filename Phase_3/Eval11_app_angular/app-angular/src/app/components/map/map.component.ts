import {
  Component,
  AfterViewInit,
  Inject,
  PLATFORM_ID,
  Input
} from '@angular/core';
import { isPlatformBrowser } from '@angular/common';

@Component({
  selector: 'app-map',
  standalone: true,
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.scss'],
})
export class MapComponent implements AfterViewInit {

  private map!: any;
  private markersLayer!: any;

  private _schools: any[] = [];

  @Input()
  set schools(value: any[]) {
    this._schools = value || [];
    this.addMarkers();
  }

  constructor(@Inject(PLATFORM_ID) private platformId: Object) {}

  async ngAfterViewInit(): Promise<void> {
    if (!isPlatformBrowser(this.platformId)) return;

    const L = await import('leaflet');

    // ⚠️ Fix Angular + Leaflet (container déjà initialisé)
    const container = L.DomUtil.get('map');
    if (container) {
      // @ts-ignore
      container._leaflet_id = null;
    }

    this.map = L.map('map').setView([45.75, 4.85], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors',
    }).addTo(this.map);

    this.markersLayer = L.layerGroup().addTo(this.map);

    this.addMarkers();
  }

  private async addMarkers(): Promise<void> {
    if (!this.map || !this.markersLayer || this._schools.length === 0) return;

    const L = await import('leaflet');

    this.markersLayer.clearLayers();

    this._schools.forEach(school => {
      const f = school.fields;

      // ✅ LES BONNES PROPRIÉTÉS
      if (f?.latitude && f?.longitude) {
        L.circleMarker([f.latitude, f.longitude], {
          radius: 6,
          color: 'red',
          fillColor: 'red',
          fillOpacity: 0.8
        })
        .bindPopup(`
          <strong>${f.nom_etablissement}</strong><br>
          ${f.adresse_1 || ''}<br>
          ${f.code_postal} ${f.libelle_commune}
        `)
        .addTo(this.markersLayer);
      }
    });
  }
}
