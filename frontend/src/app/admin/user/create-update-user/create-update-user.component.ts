import { Component, OnInit, Injector } from '@angular/core';
import { Validators } from '@angular/forms';
import { AppComponentBase } from 'src/app/app-component-base';
import { ConfigService } from 'src/app/service/config.service';
import * as fromCountry from '../../../store/country/country.reducer';
import { CityService } from '../../../service/city.service';


@Component({
  selector: 'app-create-update-user',
  templateUrl: './create-update-user.component.html',
  styleUrls: ['./create-update-user.component.scss']
})
export class CreateUpdateUserComponent extends AppComponentBase {
  public createUser: any;
  submittedCreateUser = false;
  dataToEdit = '';
  countries = [];
  country_id: any;
  cities = [];
  city_id: any;
  roles = [];
  role_id: any;
  public message: any;
  params: any;

  constructor(injector: Injector, private configService: ConfigService, private cityService: CityService) {
    super(injector);
  }

  ngOnInit() {

    this.createUser = this.formBuilder.group({
      role_id: ['', Validators.required],
      first_name: ['', [Validators.required]],
      last_name: ['', [Validators.required]],
      email: ['', [Validators.required, Validators.email, Validators.pattern('^[a-zA-Z_\.\-]([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$')]],
      second_email: ['', [Validators.email, Validators.pattern('^[a-zA-Z_\.\-]([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$')]],
      country: ['', Validators.required],
      city: [''],
      phone: ['', Validators.required],
      password: [''],
    });

    this.configService.get('fetchCountries').subscribe((data) => {
      this.countries = data;

    });
    this.configService.get('fetchRoles').subscribe((data) => {
      this.roles = data;
      console.log(this.roles);
    });
    this.params = this.activatedRouter.snapshot.paramMap.get("id");
    if (this.params) {
      this.dataToEdit ='edit';
      this.spinnerService.show();
      this.configService.get('show-user/' + this.params).subscribe((data) => {
        this.cityService.fetchCitiesByCountry(data.data.country).subscribe(
          (data) => {
            this.cities = data;
          }
        );
        if (data) {
          this.city_id = data.data.city;
          this.country_id = Number(data.data.country);
          this.city_id = Number(data.data.city);
          this.role_id = Number(data.data.role_id);

          this.createUser.setValue({
            role_id: this.role_id,
            first_name: data.data.first_name,
            last_name: data.data.last_name,
            email: data.data.email,
            second_email: data.data.second_email,
            country: this.country_id,
            city: this.city_id,
            phone: data.data.phone,
            password: '',
          });



        }
        this.spinnerService.hide();
      });
    }


  }
  get cu() { return this.createUser.controls; }

  updateCountryNgModel(event) {
    if (event) {
      this.cityService.fetchCitiesByCountry(event.id).subscribe(
        (data) => {
          this.cities = data;
        }
      );
    }
    else {
      this.city_id = '';
    }
  }


  onSubmitUser() {
    if (this.dataToEdit == 'edit') {
      this.onEditUser();
    }
    else {
      this.onCreateUser();
    }

  }

  onCreateUser() {
    this.submittedCreateUser = true;
    this.message = '';
    // stop here if form is invalid

    if (this.createUser.invalid) {
      console.log('errnew');
      return;

    }



    this.spinnerService.show();
    this.configService.post('add-user', this.createUser.value).subscribe((data) => {
      console.log(data);
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {

          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('User Added Successfully!');
        this.router.navigate(["/admin/view-users"])
      }
      this.spinnerService.hide();

    });
  }

  onEditUser() {
    this.submittedCreateUser = true;
    // stop here if form is invalid

    if (this.createUser.invalid) {
      console.log('err');
      return;

    }
    var dat: { [k: string]: any } = {};

    dat.role_id = this.createUser.value.role_id;
    dat.first_name = this.createUser.value.first_name;
    dat.last_name = this.createUser.value.last_name;
    dat.email = this.createUser.value.email;
    dat.second_email = this.createUser.value.second_email;
    dat.country = this.createUser.value.country;
    dat.city = this.createUser.value.city;
    dat.phone = this.createUser.value.phone;
    dat.password = this.createUser.value.password;
    dat.id = this.params;

    this.spinnerService.show();
    this.configService.post('edit-user', dat).subscribe((data) => {
      //console.log(data.message.password[0]);
      //this.message = data.message.password[0];
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('User Updated Successfully!');
        this.router.navigate(["/admin/view-users"])
      }
      this.spinnerService.hide();
    });

  }
}
