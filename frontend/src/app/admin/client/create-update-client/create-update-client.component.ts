import { Component, OnInit, Injector } from '@angular/core';
import { Validators } from '@angular/forms';
import { AppComponentBase } from 'src/app/app-component-base';
import { ConfigService } from 'src/app/service/config.service';
import * as fromCountry from '../../../store/country/country.reducer';
// import { SearchCountryField, PhoneNumberFormat } from 'ngx-intl-tel-input';
@Component({
  selector: 'app-create-update-client',
  templateUrl: './create-update-client.component.html',
  styleUrls: ['./create-update-client.component.scss']
})
export class CreateUpdateClientComponent extends AppComponentBase {
  separateDialCode = true;
	// SearchCountryField = SearchCountryField;
	CountryISO = [];
  // PhoneNumberFormat = PhoneNumberFormat;
	preferredCountries = [];
  public createClient: any;
  submittedCreateClient = false;
  dataToEdit = '';
  countries = [];
  country_id = '';
  phone: '';
  params : any;
  emailPattern = "^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$";
  constructor(injector: Injector, private configService: ConfigService) {
    super(injector);
  }
	changePreferredCountries() {
		this.preferredCountries = ['us', 'gb'];
	}
  ngOnInit() {
    this.createClient = this.formBuilder.group({
      id:null,
      client_name: ['',  [Validators.required]],
      contact_person_name: ['',  [Validators.required]],
      company_name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      email2: ['', [Validators.email]],
      phone: ['', Validators.required],
      country_code: [''],
      is_active: ['', Validators.required]
    });

    this.store.select(fromCountry.getAllCountries).subscribe(
      (data) => {
        this.countries = data;
      }
    ); 
    this.params = this.activatedRouter.snapshot.paramMap.get("id");
    if (this.params) {
      this.spinnerService.show();
      this.configService.get('get-client-by-id/' +this.params).subscribe((data) => {
          this.dataToEdit = 'edit';
          let str = data.data.phone;
           str = str.slice(3);
          this.preferredCountries = [data.data.country_code];
          console.log(this.preferredCountries);

          this.createClient.setValue({
            id: this.params,
            client_name: data.data.client_name,
            contact_person_name: data.data.contact_person_name,
            company_name: data.data.company_name,
            email: data.data.email,
            email2: data.data.email2,
            phone: str,
            country_code:data.data.country_code.toLowerCase(),
            is_active: data.data.is_active,
          });
          this.spinnerService.hide();
      });
    }
    

  }

  get cu() { return this.createClient.controls; }

  updateCountryNgModel(event) {
    if(event){
      this.country_id = event.id;
      this.createClient.get('country_id').setValue(event.id);    
    }
    else{
      this.country_id = '';
      this.createClient.get('country_id').setValue('');      
    }
  }

  onSubmitClient() {
    if (this.dataToEdit == 'edit') {
      this.onEditClient();
    }
    else {
      this.onCreateClient();
    }
  }

  onCreateClient() {
    this.submittedCreateClient = true;
    // stop here if form is invalid
    console.log(this.createClient.controls);

    if (this.createClient.invalid) {
      return;
    }
    console.log(this.createClient.get('phone').value.e164Number);
    this.createClient.get('phone').setValue(this.createClient.get('phone').value.e164Number);    
    this.createClient.get('country_code').setValue(this.createClient.get('phone').value.countryCode);    
    this.spinnerService.show();
    this.configService.post('client-store', this.createClient.value).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('Client Added Successfully!');
        this.router.navigate(['/admin/view-clients']); 
      }
      this.spinnerService.hide();
    });
  }

  onEditClient() {
    this.submittedCreateClient = true;
    // stop here if form is invalid
    console.log(this.createClient.controls);

    if (this.createClient.invalid) {
      return;
    }

    var dat: { [k: string]: any } = {};
    dat.client_name= this.createClient.value.client_name;
    dat.contact_person_name= this.createClient.value.contact_person_name;
    dat.company_name= this.createClient.value.company_name;
    dat.email= this.createClient.value.email;
    dat.email2= this.createClient.value.email2;
    dat.phone=  this.createClient.get('phone').value.e164Number;    
    dat.country_code = this.createClient.get('phone').value.countryCode.toLowerCase();
    dat.is_active= this.createClient.value.is_active;
    dat.id = this.params;

    this.spinnerService.show();
    this.configService.post('client-update', dat).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        
        this.toastr.success('Client Updated Successfully!');
        this.router.navigate(['/admin/view-clients']); 
      }
      this.spinnerService.hide();
    });

  }
}
