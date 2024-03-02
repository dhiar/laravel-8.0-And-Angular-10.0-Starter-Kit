import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from '../SharedModule.module';
import { AuthenticationService } from '../service/authentication.service';
import { AdminRoutingModule } from './admin-routing.module';
import { ApplicationPipesModule } from '../customPipes/customPipe.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
// import { NgxIntlTelInputModule } from 'ngx-intl-tel-input';

import { DashboardComponent } from './dashboard/dashboard.component';

import { ProfileComponent } from './profile/profile.component';

// import { CountryComponent } from './settings/country/country.component';
// import { CUCountryComponent } from './settings/country/cucountry/cu-country.component';

// import { CstateComponent } from './settings/cstate/cstate.component';
// import { CUStateComponent } from './settings/cstate/custate/cu-state.component';

// import { CityComponent } from './settings/city/city.component';
// import { CUCityComponent } from './settings/city/cu-city/cu-city.component';

// import { ZoneComponent } from './settings/zone/zone.component';
// import { CUZoneComponent } from './settings/zone/cu-zone/cu-zone.component';


import { CountryComponent } from './settings/country/country.component';
import { CstateComponent } from './settings/cstate/cstate.component';
import { CityComponent } from './settings/city/city.component';
import { ZoneComponent } from './settings/zone/zone.component';



import { MapComponent } from './settings/map/map.component';
import { MapViewComponent } from './location/map_view/map_view.component';


import { ViewClientComponent } from './client/view-client/view-client.component';
import { CreateUpdateClientComponent } from './client/create-update-client/create-update-client.component';

import { ViewUserComponent } from './user/view-user/view-user.component';
import { CreateUpdateUserComponent } from './user/create-update-user/create-update-user.component';

import { ViewCurrencyComponent } from './currency/view-currency/view-currency.component';
import { CreateUpdateCurrencyComponent } from './currency/create-update-currency/create-update-currency.component';

import { ViewLanguageComponent } from './language/view-language/view-language.component';
import { CreateUpdateLanguageComponent } from './language/create-update-language/create-update-language.component';

import { ViewRoleComponent } from './role/view-role/view-role.component';
import { CreateUpdateRoleComponent } from './role/create-update-role/create-update-role.component';

import { PermissionComponent } from './role/permissions/permission.component';

import { ViewLocationComponent } from './location/view-location/view-location.component';
import { CreateUpdateLocationComponent } from './location/create-update-location/create-update-location.component';

import { DashboaradminComponent } from './admin.component';
import { HeaderComponent } from './shared/header/header.component';
import { SidebarComponent } from './shared/sidebar/sidebar.component';
import { ExcelService } from '../service/excel.service';



@NgModule({
  declarations: [
    DashboardComponent,
    DashboaradminComponent,
    SidebarComponent,
    HeaderComponent,
    ProfileComponent,
    ViewClientComponent,
    CreateUpdateClientComponent,
    ViewUserComponent,
    CreateUpdateUserComponent,
    CountryComponent,
    CountryComponent,
    CstateComponent,
    CityComponent,
    ZoneComponent,
    // CUCountryComponent,
    // CstateComponent,
    // CUStateComponent ,
    // CityComponent,
    // CUCityComponent,
    // ZoneComponent,
    // CUZoneComponent,
    MapComponent,
    MapViewComponent,
    ViewCurrencyComponent,
    CreateUpdateCurrencyComponent,
    ViewLanguageComponent,
    CreateUpdateRoleComponent,
    ViewRoleComponent,
    PermissionComponent,
    CreateUpdateLanguageComponent,
    ViewLocationComponent,
    CreateUpdateLocationComponent
  ],
  imports: [
    CommonModule,
    FormsModule,
    // NgxIntlTelInputModule,
    ReactiveFormsModule,
    AdminRoutingModule,
    SharedModule,
    ApplicationPipesModule,

  ],

  providers: [ExcelService,AuthenticationService],
  bootstrap: [DashboaradminComponent]
})
export class AdminModule { }
