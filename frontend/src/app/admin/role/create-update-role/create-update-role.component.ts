import { Component, OnInit, Injector } from '@angular/core';
import { Validators } from '@angular/forms';
import { AppComponentBase } from 'src/app/app-component-base';
import { ConfigService } from 'src/app/service/config.service';
import * as fromCountry from '../../../store/country/country.reducer';

@Component({
  selector: 'app-create-update-role',
  templateUrl: './create-update-role.component.html',
  styleUrls: ['./create-update-role.component.scss']
})
export class CreateUpdateRoleComponent extends AppComponentBase {
  public createRole: any;
  submittedCreateRole = false;
  dataToEdit = '';

  constructor(injector: Injector, private configService: ConfigService) {
    super(injector);
  }

  ngOnInit() {
    var params = this.activatedRouter.snapshot.paramMap.get("id");
    if (params) {
      this.spinnerService.show();
      this.configService.get('fetchRoleById/' + params,).subscribe((data) => {
        if (data) {
          this.dataToEdit = 'edit';
          this.createRole = this.formBuilder.group({
            id: params,
            name: [data.name, [Validators.required, Validators.pattern('^[a-zA-Z ]*$')]],
            is_active: [data.is_active, Validators.required],
          });
          this.spinnerService.hide();
        }
      });
    }
    else {
      this.dataToEdit = 'create';
      this.createRole = this.formBuilder.group({
        name: ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$')]],
        is_active: ['', Validators.required],
      });
    }

  }
  get cu() { return this.createRole.controls; }


  onFileSelect(event) {
    if (event.target.files.length > 0) {
      const file = event.target.files[0];
      this.createRole.get('image').setValue(file);
    }
  }

  onSubmitRole() {
    if (this.dataToEdit == 'create') {
      this.onCreateRole();
    }
    else {
      this.onEditRole();
    }

  }

  onCreateRole() {
    this.submittedCreateRole = true;
    // stop here if form is invalid
    if (this.createRole.invalid) {
      return;
    }
    this.spinnerService.show();
    this.configService.post('addRole', this.createRole.value).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('Role Added Successfully!');
        this.router.navigate(["/admin/view-role"]);
      }
      this.spinnerService.hide();

    });
  }

  onEditRole() {
    this.submittedCreateRole = true;
    // stop here if form is invalid
    if (this.createRole.invalid) {
      return;
    }
    this.spinnerService.show();
    this.configService.post('updateRole', this.createRole.value).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('Role Updated Successfully!');
        this.router.navigate(["/admin/view-role"]);
      }
      this.spinnerService.hide();
    });

  }
}
