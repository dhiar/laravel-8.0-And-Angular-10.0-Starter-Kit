import { Component, Input, OnInit, Injector } from '@angular/core';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import { MapViewService } from '../../../service/map_view.service';
import { AppComponentBase } from 'src/app/app-component-base';
import { ZoneService } from '../../../service/zone.service';
import { ConfigService } from 'src/app/service/config.service';

import { 
  
 } from 'src/app/service/config.service';

declare function initializeOnLocation(agr1:any, agr2:any):any;
declare function initializeLocationsMarker(any):any;
declare function returnCoords():any;

@Component({
  selector: 'app-map_view',
  templateUrl: './map_view.component.html',
  styleUrls: ['./map_view.component.scss']
})
export class MapViewComponent extends AppComponentBase {

  zone_id  : '';
  coords : any;
  updated_sites : any;

  constructor(injector: Injector,private map_viewService: MapViewService, private zoneService : ZoneService, private config : ConfigService) {
    super(injector);
  }

  async ngOnInit() {
    // this.zone_id = this.actRoute.snapshot.params.id;
    this.config.get('get-all-site').subscribe(
      (dataa) => {
        this.zoneService.getAllZones().subscribe(
          (data) => {
            console.log(data);
            console.log(dataa);

            initializeOnLocation(data,dataa);
    
          } 
        );  
    });
  
  }

  updatedCoords(){
    this.updated_sites = returnCoords();
    console.log(this.coords);
    this.spinnerService.show();
    this.config.post('update-sites-by-map' ,  this.updated_sites).subscribe((data) => {
      this.toastr.success('Locations Updated Successfully!');
      this.spinnerService.hide();
    });
    
  }


}
