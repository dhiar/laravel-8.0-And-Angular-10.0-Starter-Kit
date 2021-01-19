import { Component, OnInit } from '@angular/core';
import { Country } from './store/country/country.model';
import { Store, select } from '@ngrx/store';
import * as fromCountry from './store/country/country.reducer';
import * as countryActions from './store/country/country.actions';
import * as fromZone from './store/zone/zone.reducer';
import * as zoneActions from './store/zone/zone.actions';
import { NgxSpinnerService } from "ngx-spinner";
import { ToastrService } from 'ngx-toastr';
import { ConfigService } from './service/config.service';

// import { getLocaleCurrencySymbol } from '@angular/common';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  ipAddress:string;
  constructor(private confir:ConfigService, private store: Store<fromCountry.State>) {}
  ngOnInit()
  {
    this.store.dispatch(new countryActions.LoadAllCountries());
    this.store.dispatch(new zoneActions.LoadAllZones());
  }
}
