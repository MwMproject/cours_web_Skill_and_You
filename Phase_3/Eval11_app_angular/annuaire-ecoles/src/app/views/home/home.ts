import { Component, OnInit } from '@angular/core';
import { MapComponent } from '../../components/map/map';
import { SchoolService } from '../../services/school.service';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [MapComponent],
  templateUrl: './home.html',
  styleUrl: './home.scss',
})
export class Home implements OnInit {

  schools: any[] = [];

  constructor(private schoolService: SchoolService) {}

  ngOnInit(): void {
    this.schoolService.getSchoolsByCity('Lyon').subscribe(res => {
      this.schools = res.records;
    });
  }
}
