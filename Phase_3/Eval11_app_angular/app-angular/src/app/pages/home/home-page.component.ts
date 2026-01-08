import { Component, OnInit } from '@angular/core';
import { SchoolService } from '../../services/school.service';
import { SchoolRecord } from '../../services/school.model';

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.scss']
})
export class HomePageComponent implements OnInit {
  city = 'Lyon';
  schools: SchoolRecord[] = [];
  selected?: SchoolRecord;

  loading = true;

  constructor(private schoolService: SchoolService) {}

  ngOnInit(): void {
    this.schoolService.getSchoolsByCity(this.city).subscribe(records => {
      this.schools = records;
      this.loading = false;
    });
  }

  onSelectSchool(s: SchoolRecord): void {
    this.selected = s;
  }
}
