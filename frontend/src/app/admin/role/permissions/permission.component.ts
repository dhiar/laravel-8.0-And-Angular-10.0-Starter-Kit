import { Component, OnInit, Injector } from '@angular/core';
import { Validators } from '@angular/forms';
import { AppComponentBase } from 'src/app/app-component-base';
import { ConfigService } from 'src/app/service/config.service';
import * as fromCountry from '../../../store/country/country.reducer';

@Component({
  selector: 'app-permission',
  templateUrl: './permission.component.html',
  styleUrls: ['./permission.component.scss']
})
export class PermissionComponent extends AppComponentBase {
  role_id : any;
  all : any;
  selected :any;

  constructor(injector: Injector, private configService: ConfigService) {
    super(injector);
  }

  ngOnInit() {
    var params = this.activatedRouter.snapshot.paramMap.get("id");
    this.role_id = params;
    //   this.createPermission = this.formBuilder.group({
    //   role_id: this.role_id,
    //   selected: [''],
    // });
      this.spinnerService.show();
      this.configService.get('fetchAllPermissions/' + params).subscribe((data) => {
         this.all = data;
         this.spinnerService.hide();
      });
      this.configService.get('fetchPermissions/' + params).subscribe((data) => {
        if (data) {
          this.selected = data;
        }
      });

  }
  getSel() {
    for(let i=0;i<this.selected.length; i++){
      for(let j=0;j<this.all.length;j++){
        if(this.all[j].id === this.selected[i].id) {
          this.all[j].checked = true;
        }
      }
    }
  }
  getallSel() {
  //  for(let i=0;i<this.selected.length; i++){
      for(let j=0;j<this.all.length;j++){
       // if(this.all[j].id === this.selected[i].id) {
          this.all[j].checked = true;
        //}
      }
    //}
  }


   add() {
    // this.spinnerService.show();

     var t = this.all
      .filter(opt => opt.checked)
      .map(opt => opt);
    this.selected = t;
    var permissions_ids = this.selected;
    console.log( this.selected);
    this.configService.post('updatePermission', {permissions_ids : permissions_ids,role_id : this.role_id}).subscribe((data) => {
      if (data.success == 0) {
        for (const [key, value] of Object.entries(data.message)) {
          this.toastr.warning(`Ops! ${value}`);
        }
      }
      else {
        this.toastr.success('Permissions Updated Successfully!');
        this.router.navigate(['/admin/view-role']);
      }

    });
   }

}
