import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomePageComponent } from './pages/home/home-page.component';
import { ContactPageComponent } from './pages/contact/contact-page.component';

const routes: Routes = [
  { path: '', component: HomePageComponent },
  { path: 'contact', component: ContactPageComponent },
  { path: '**', redirectTo: '' },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
