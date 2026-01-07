import { Component } from '@angular/core';
import { SchoolService } from '../../services/school.service';
import { MapComponent } from '../../components/map/map';


@Component({
  selector: 'app-home',
  imports: [MapComponent],
  templateUrl: './home.html',
  styleUrl: './home.scss',
})
export class Home {
   constructor(private schoolService: SchoolService) {
    this.schoolService.getSchoolsByCity('Lyon').subscribe(res => {
      console.log('Réponse API :', res);
    });
  }

}
