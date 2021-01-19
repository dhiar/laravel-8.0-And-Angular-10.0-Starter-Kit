import { Component, Input, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import * as fromCountry from '../../../store/country/country.reducer';
import { Zone } from '../../../store/zone/zone.model';
import { ZoneService } from '../../../service/zone.service';
import { CstateService } from '../../../service/cstate.service';
import { CityService } from '../../../service/city.service';

import { Store, select } from '@ngrx/store';
import * as fromZone from '../../../store/zone/zone.reducer';
import * as zoneActions from '../../../store/zone/zone.actions';
import { ToastrService } from 'ngx-toastr';
import { map, switchMap, take } from 'rxjs/operators';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from "ngx-spinner";
import {TranslateService} from '@ngx-translate/core';


@Component({
  selector: 'app-zone',
  templateUrl: './zone.component.html',
  styleUrls: ['./zone.component.scss']
})
export class ZoneComponent implements OnInit {
  apiUrl = environment.apiUrl;
  uploadForm: FormGroup;
  editForm: FormGroup;
  countries:[] = [];
  cstates:[] = [];
  cities:[] = [];
  zones:[] = [];
  country_id:'';
  cstate_id:'';
  city_id:'';
  paginate_links: any;
  prev_page_url: any;
  next_page_url: any;
  data_sort_order: string = 'ASC';
  sorted_colum: string = 'id';
  pageNumberdefault: number = 1;
  error$: Observable<any>;
  messages$: Observable<any>;
  data: any;
  message_status: string = '';
  message_for_toast: string = '';
  search_column = 'id';
  search_text: '';


  constructor(private translate: TranslateService,  private spinner: NgxSpinnerService, private zoneService: ZoneService,private cityService: CityService, private cstateService: CstateService, private toastr: ToastrService, private formBuilder: FormBuilder, private store: Store<fromZone.State>) {
  }

  async ngOnInit() {
    this.translate.use('en');
    this.uploadForm = this.formBuilder.group({
      id: '',
      name: '',
      status: '',
      country_id: '',
      state_id: '',
      city_id:''
    });
    this.editForm = this.formBuilder.group({
      id: '',
      name: '',
      code: '',
      status: '',
      country_id: '',
      state_id: '',
      city_id:''
    });
    this.store.dispatch(new zoneActions.LoadZonesByPage({ 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' }));
    this.error$ = this.store.pipe(select(fromZone.getError));
    this.store.select(fromZone.getError).subscribe(
      (data) => {
        if(data){
          this.spinner.hide();
        }
      }
    );
    this.store.select(fromCountry.getAllCountries).subscribe(
      (data) => {
        this.countries = data;
      }
    );
    this.store.select(fromZone.getZonesByPage).subscribe(
      (data) => {
        this.spinner.show();
        this.zones = data.data;
        this.paginate_links = data.links;
        this.prev_page_url = data.prev_page_url;
        this.next_page_url = data.next_page_url;
        this.spinner.hide();
      }
    );
    this.store.select(fromZone.getMessage).subscribe(
      (dataa) => {
        this.message_for_toast = dataa.messsage;
        this.message_status = dataa.status;
        if (this.message_status == 'success') {
          this.uploadForm.get('name').setValue('');
          this.uploadForm.get('status').setValue('');
          this.uploadForm.get('country_id').setValue('');
          this.toastr.success(this.message_for_toast);
          this.spinner.hide();
        }
        if (this.message_status == 'danger') {
          this.toastr.warning(this.message_for_toast);
          this.spinner.hide();
        }

      }
    );


  }
  isNumber(val): boolean { return typeof val === 'number'; }
  isCenter(val): boolean { return val === '...'; }
  isPrevious(val): boolean { return val === '&laquo; Previous'; }
  isNext(val): boolean { return val === 'Next &raquo;'; }

  updateCountryNgModel(event) {
    if(event){
      this.country_id = event.id;
      this.cstateService.getStatesByCountry(this.country_id).subscribe(
        (data) => {
          this.cstates = data;
        }
      );     
    }
    else{
      this.country_id = '';  
    }

  }
  updateStateNgModel(event) {
    console.log(event);

    if(event){
      this.cstate_id = event.id;
      console.log(this.cstate_id);
      this.cityService.fetchCitiesByState(this.cstate_id).subscribe(
        (data) => {
          this.cities = data;
          console.log(this.cities);
        }
      );     
    }
    else{
      this.cstate_id = '';  
    }
     
  }
   updateCityNgModel(event) {
    if(event){
      this.city_id = event.id;  
    }
    else{
      this.city_id = '';  
    }
     
  }
  submitForm() {
    this.spinner.show();
    this.uploadForm.get('country_id').setValue(this.country_id);
    this.uploadForm.get('state_id').setValue(this.cstate_id);
    this.uploadForm.get('city_id').setValue(this.city_id);
    const formData = new FormData();
    formData.append('name', this.uploadForm.get('name').value);
    formData.append('status', this.uploadForm.get('status').value);
    formData.append('country_id', this.country_id);
    formData.append('state_id', this.cstate_id);
    formData.append('city_id', this.city_id);
    this.store.dispatch(new zoneActions.CreateZone(this.uploadForm.value));
  }
  previousPage(pageNumber) {
    var pageNumber = pageNumber.split("=", 3);
    let obj = { 'pageNumber': pageNumber[1], 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new zoneActions.LoadZonesByPage(obj));
  }
  pageNumber(pageNumber) {
    let obj = { 'pageNumber': pageNumber, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new zoneActions.LoadZonesByPage(obj));
  }
  nextPage(pageNumber) {
    var pageNumber = pageNumber.split("=", 3);
    let obj = { 'pageNumber': pageNumber[1], 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new zoneActions.LoadZonesByPage(obj));
  }
  sortData(colum) {
    let obj = { 'pageNumber': this.pageNumberdefault, 'data_sort_order': this.data_sort_order, 'sorted_colum': colum, 'searchColumn': '', 'searchText': '' };
    if (this.data_sort_order == 'ASC') {
      this.store.dispatch(new zoneActions.LoadZonesByPage(obj));
      this.data_sort_order = 'DESC';
    }
    else {
      this.store.dispatch(new zoneActions.LoadZonesByPage(obj));
      this.data_sort_order = 'ASC';
    }
  }
  updateSearchColumnValue(e) {
    this.search_column = e;
  }
  searchData(e) {
    if (this.search_column != '') {
      let obj = { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': this.search_column, 'searchText': e };
      this.store.dispatch(new zoneActions.LoadZonesByPage(obj));
    }
  }
  fetchDataToEdit(id) {

    this.zoneService.fetchDataToEdit(id).subscribe(
      (dataZone) => {
        this.country_id = dataZone.country_id;
        this.cstateService.getStatesByCountry(this.country_id).subscribe(
          (dataState) => {
            if(dataZone.state_id){
              this.cstates = dataState;
              this.cstate_id = dataZone.state_id;
              this.cityService.fetchCitiesByState(this.cstate_id).subscribe(
                (dataCity) => {
                  this.cities = dataCity;
                  this.city_id = dataZone.city_id;
                  console.log('by State');   
                }
              ); 
            }
            else{
              this.cityService.fetchCitiesByCountry(this.country_id).subscribe(
                (dataCity) => {
                  this.cities = dataCity;
                  this.city_id = dataZone.city_id;
                  console.log('by Country');  
                }
              ); 
            }

          }
        );

        this.editForm.get('id').setValue(dataZone.id);
        this.editForm.get('name').setValue(dataZone.name);
        this.editForm.get('status').setValue(dataZone.status);
        this.editForm.get('country_id').setValue(this.country_id);
        this.editForm.get('state_id').setValue(this.cstate_id);
        this.editForm.get('city_id').setValue(this.city_id);

      }
    );
  }
  submitEditForm() {
    this.spinner.show();
    this.editForm.get('country_id').setValue(this.country_id);
    this.editForm.get('state_id').setValue(this.cstate_id);
    this.editForm.get('city_id').setValue(this.city_id);

    const formData = new FormData();
    formData.append('id', this.editForm.get('id').value);
    formData.append('name', this.editForm.get('name').value);
    formData.append('status', this.editForm.get('status').value);
    formData.append('country_id', this.country_id);
    formData.append('state_id', this.cstate_id);
    formData.append('city_id', this.city_id);
    this.store.dispatch(new zoneActions.UpdateZone(this.editForm.value));
  }
  handleZoneDeletion(zoneId){
    this.store.dispatch(new zoneActions.DeleteZone(zoneId));
  }

}
