import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-contact-page',
  templateUrl: './contact-page.component.html',
  styleUrls: ['./contact-page.component.scss']
})
export class ContactPageComponent implements OnInit {

  schoolName?: string;
  schoolCity?: string;
  submitted = false;

  form!: FormGroup;

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.form = this.fb.group({
      nom: ['', Validators.required],
      prenom: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      objet: ['', Validators.required],
      message: ['', Validators.required],
      cgu: [false, Validators.requiredTrue],
    });

    this.route.queryParams.subscribe(p => {
      this.schoolName = p['nom'];
      this.schoolCity = p['ville'];

      if (this.schoolName) {
        this.form.patchValue({
          objet: `Demande de contact – ${this.schoolName}`
        });
      }
    });
  }

  submit(): void {
    this.submitted = true;
    if (this.form.invalid) return;

    console.log('Formulaire factice envoyé :', this.form.value);
    alert('Formulaire validé (aucun envoi réel).');

    this.form.reset({ cgu: false });
    this.submitted = false;
  }
}
