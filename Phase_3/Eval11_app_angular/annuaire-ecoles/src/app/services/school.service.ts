import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class SchoolService {

  private apiUrl = 'https://data.education.gouv.fr/api/records/1.0/search/';

  constructor(private http: HttpClient) {}

  getSchoolsByCity(city: string): Observable<any> {
    return this.http.get<any>(this.apiUrl, {
      params: {
        dataset: 'fr-en-annuaire-education',
        'refine.libelle_commune': city,
        rows: '100'
      }
    });
  }
}
