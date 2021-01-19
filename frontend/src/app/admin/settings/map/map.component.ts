import { Component, Input, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import { MapService } from '../../../service/map.service';
import { ToastrService } from 'ngx-toastr';
import { ActivatedRoute } from '@angular/router';
declare function initialize(any):any;
declare function returnCoords():any;

@Component({
  selector: 'app-map',
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.scss']
})
export class MapComponent implements OnInit {

  zone_id  : '';
  coords : any;

  constructor(private actRoute: ActivatedRoute, private mapService: MapService, private toastr: ToastrService) {
    this.zone_id = this.actRoute.snapshot.params.id;
  }

  async ngOnInit() {
    this.zone_id = this.actRoute.snapshot.params.id;
    this.mapService.getCords(this.zone_id).subscribe(
      (data) => {
        initialize(data.coordinates);
        console.log(data.coordinates);
      }
    );   
  }

  updatedCoords(){
    this.coords = returnCoords();
    console.log(this.coords);
    this.mapService.updateCords(this.coords,this.zone_id).subscribe(
      (data) => {
        this.toastr.success('Your Zone Coordinates Updated SuccessFully');
      }
    );   
  }


}
