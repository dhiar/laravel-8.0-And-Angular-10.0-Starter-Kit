import { Component, OnInit, Injector } from '@angular/core';
import { Validators } from '@angular/forms';
import { AppComponentBase } from 'src/app/app-component-base';
import { ConfigService } from 'src/app/service/config.service';
import { environment } from 'src/environments/environment';
import * as fromCountry from '../../../store/country/country.reducer';

@Component({
  selector: 'app-create-update-language',
  templateUrl: './create-update-language.component.html',
  styleUrls: ['./create-update-language.component.scss']
})
export class CreateUpdateLanguageComponent extends AppComponentBase {
  public createLanguage: any;
  submittedCreateLanguage = false;
  apiUrl = environment.apiUrl;
  dataToEdit = '';
  countries = [];
  country_id = '';
  currentImage : null;

  constructor(injector: Injector, private configService: ConfigService) {
    super(injector);
  }

  ngOnInit() {
    this.store.select(fromCountry.getAllCountries).subscribe(
      (data) => {
        this.countries = data;
      }
    ); 
    var params = this.activatedRouter.snapshot.paramMap.get("id");
    if (params) {
      this.spinnerService.show();
      this.configService.get('fetchLanguageById/' + params,).subscribe((data) => {
        if (data) {
          this.createLanguage = this.formBuilder.group({
            id: params,
            name: [data.name, Validators.required],
            short_code: [data.short_code, [Validators.required,Validators.pattern('^[a-z]{2,}$')]],
            is_active: [data.is_active, Validators.required],
            image: [data.image],
          });
          this.spinnerService.hide();
          this.country_id = data.country_id;
          this.currentImage = data.image;
          this.dataToEdit = 'edit';
        }
      });
    }
    else {
      this.dataToEdit = 'create';
      this.createLanguage = this.formBuilder.group({
        name: ['', Validators.required],
        short_code: ['', [Validators.required, Validators.pattern('^[a-z]{2,}$')]],
        is_active: ['', Validators.required],
        image: [null],
      });
    }

  }
  get cu() { return this.createLanguage.controls; }



  upload(event) {
    const file = (event.target as HTMLInputElement).files[0];
    this.createLanguage.patchValue({
      image: file
    });
    this.createLanguage.get('image').updateValueAndValidity()
 }

  onSubmitLanguage() {
    if (this.dataToEdit == 'create') {
      this.onCreateLanguage();
    }
    else {
      this.onEditLanguage();
    }

  }

  onCreateLanguage() {
    this.submittedCreateLanguage = true;
    // stop here if form is invalid
    if (this.createLanguage.invalid) {
      return;
    }
    this.spinnerService.show();
    var formData: any = new FormData();
    formData.append('name', this.createLanguage.get('name').value);
    formData.append('short_code', this.createLanguage.get('short_code').value);
    formData.append('is_active', this.createLanguage.get('is_active').value);
    formData.append('image', this.createLanguage.get('image').value);

    this.configService.post('addLanguage', formData).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('Language Added Successfully!');
        this.router.navigate(['/admin/view-language']);

      }
      this.spinnerService.hide();

    });
  }

  onEditLanguage() {
    this.submittedCreateLanguage = true;
    // stop here if form is invalid
    if (this.createLanguage.invalid) {
      return;
    }
    this.spinnerService.show();
    var formData: any = new FormData();
    formData.append('id', this.createLanguage.get('id').value);
    formData.append('name', this.createLanguage.get('name').value);
    formData.append('short_code', this.createLanguage.get('short_code').value);
    formData.append('is_active', this.createLanguage.get('is_active').value);
    formData.append('image', this.createLanguage.get('image').value);
    this.configService.post('updateLanguage', formData).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('Language Updated Successfully!');
        this.router.navigate(['/admin/view-language']);

      }
      this.spinnerService.hide();
    });

  }
}
