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
  templateUrl: './map.html',
  styleUrl: './map.scss',
})
export class MapComponent implements AfterViewInit {

  private map: any;
  private _schools: any[] = [];

  @Input()
  set schools(value: any[]) {
    this._schools = value ?? [];
    this.displayMarkers();
  }

  constructor(@Inject(PLATFORM_ID) private platformId: Object) {}

  async ngAfterViewInit(): Promise<void> {
    if (!isPlatformBrowser(this.platformId)) return;

    const L = await import('leaflet');

    // Reset du conteneur Leaflet (Angular friendly)
    const container = L.DomUtil.get('map');
    if (container) {
      // @ts-ignore
      container._leaflet_id = null;
    }

    // Carte centrée sur Lyon
    this.map = L.map('map').setView([45.75, 4.85], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(this.map);

    this.displayMarkers();
  }

  private async displayMarkers(): Promise<void> {
    if (!this.map || !this._schools.length) return;

    const L = await import('leaflet');

    this._schools.forEach((school, index) => {
      // Positionnement volontaire dans la zone de Lyon
      const lat = 45.75 + (Math.random() - 0.5) * 0.05;
      const lon = 4.85 + (Math.random() - 0.5) * 0.05;

      L.marker([lat, lon])
        .addTo(this.map)
        .bindPopup(`
          <strong>${school.fields.nom_etablissement}</strong><br>
          ${school.fields.adresse_1 || ''}<br>
          ${school.fields.type_etablissement || ''}
        `);
    });

    console.log(`✔️ ${this._schools.length} établissements affichés`);
  }
}