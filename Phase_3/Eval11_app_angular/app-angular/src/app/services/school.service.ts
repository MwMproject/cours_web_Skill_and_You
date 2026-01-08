import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map, Observable } from 'rxjs';
import { SchoolRecord } from './school.model';

@Injectable({ providedIn: 'root' })
export class SchoolService {
  private apiUrl = 'https://data.education.gouv.fr/api/records/1.0/search/';

  constructor(private http: HttpClient) {}

  getSchoolsByCity(city: string): Observable<SchoolRecord[]> {
    return this.http.get<any>(this.apiUrl, {
      params: {
        dataset: 'fr-en-annuaire-education',
        'refine.libelle_commune': city,
        rows: '200'
      }
    }).pipe(map(res => (res?.records ?? []) as SchoolRecord[]));
  }
}
