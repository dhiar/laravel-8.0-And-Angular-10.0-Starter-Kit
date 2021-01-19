import { Component, Input, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import * as fromCountry from '../../../store/country/country.reducer';
import { Cstate } from '../../../store/cstate/cstate.model';
import { CstateService } from '../../../service/cstate.service';
import { Store, select } from '@ngrx/store';
import * as fromCstate from '../../../store/cstate/cstate.reducer';
import * as cstateActions from '../../../store/cstate/cstate.actions';
import { ToastrService } from 'ngx-toastr';
import { map, switchMap, take } from 'rxjs/operators';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from "ngx-spinner";
import {TranslateService} from '@ngx-translate/core';


@Component({
  selector: 'app-cstate',
  templateUrl: './cstate.component.html',
  styleUrls: ['./cstate.component.scss']
})
export class CstateComponent implements OnInit {
  apiUrl = environment.apiUrl;
  uploadForm: FormGroup;
  editForm: FormGroup;
  countries:[] = [];
  cstates:[] = [];
  country_id:'';
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


  constructor(private translate: TranslateService,  private spinner: NgxSpinnerService, private cstateService: CstateService, private toastr: ToastrService, private formBuilder: FormBuilder, private store: Store<fromCstate.State>) {
  }

  async ngOnInit() {
    this.translate.use('en');
    this.uploadForm = this.formBuilder.group({
      id: '',
      name: '',
      status: '',
      country_id: ''
    });
    this.editForm = this.formBuilder.group({
      id: '',
      name: '',
      code: '',
      status: '',
      country_id: ''
    });
    this.store.dispatch(new cstateActions.LoadCstatesByPage({ 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' }));
    this.error$ = this.store.pipe(select(fromCstate.getError));
    this.store.select(fromCstate.getError).subscribe(
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
    this.store.select(fromCstate.getCstatesByPage).subscribe(
      (data) => {
        this.spinner.show();
        this.cstates = data.data;
        this.paginate_links = data.links;
        this.prev_page_url = data.prev_page_url;
        this.next_page_url = data.next_page_url;
        this.spinner.hide();
      }
    );
    this.store.select(fromCstate.getMessage).subscribe(
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

  updateNgModel(event) {
     this.country_id = event.id;
     console.log(this.country_id);   
  }
  submitForm() {
    this.spinner.show();
    console.log(this.country_id);
    this.uploadForm.get('country_id').setValue(this.country_id);

    const formData = new FormData();
    this.uploadForm.get('country_id').value
    formData.append('name', this.uploadForm.get('name').value);
    formData.append('status', this.uploadForm.get('status').value);
    formData.append('country_id', this.country_id);
    this.store.dispatch(new cstateActions.CreateCstate(this.uploadForm.value));
  }
  previousPage(pageNumber) {
    var pageNumber = pageNumber.split("=", 3);
    let obj = { 'pageNumber': pageNumber[1], 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new cstateActions.LoadCstatesByPage(obj));
  }
  pageNumber(pageNumber) {
    let obj = { 'pageNumber': pageNumber, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new cstateActions.LoadCstatesByPage(obj));
  }
  nextPage(pageNumber) {
    var pageNumber = pageNumber.split("=", 3);
    let obj = { 'pageNumber': pageNumber[1], 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new cstateActions.LoadCstatesByPage(obj));
  }
  sortData(colum) {
    let obj = { 'pageNumber': this.pageNumberdefault, 'data_sort_order': this.data_sort_order, 'sorted_colum': colum, 'searchColumn': '', 'searchText': '' };
    if (this.data_sort_order == 'ASC') {
      this.store.dispatch(new cstateActions.LoadCstatesByPage(obj));
      this.data_sort_order = 'DESC';
    }
    else {
      this.store.dispatch(new cstateActions.LoadCstatesByPage(obj));
      this.data_sort_order = 'ASC';
    }
  }
  updateSearchColumnValue(e) {
    this.search_column = e;
  }
  searchData(e) {
    if (this.search_column != '') {
      let obj = { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': this.search_column, 'searchText': e };
      this.store.dispatch(new cstateActions.LoadCstatesByPage(obj));
    }
  }
  fetchDataToEdit(id) {

    this.cstateService.fetchDataToEdit(id).subscribe(
      (data) => {
        console.log(data);
        this.country_id = data.country_id;
        this.editForm.get('id').setValue(data.id);
        this.editForm.get('name').setValue(data.name);
        this.editForm.get('status').setValue(data.is_active);
        this.editForm.get('country_id').setValue(this.country_id);
      }
    );
  }
  submitEditForm() {
    this.spinner.show();
    this.editForm.get('country_id').setValue(this.country_id);
    const formData = new FormData();
    formData.append('id', this.editForm.get('id').value);
    formData.append('name', this.editForm.get('name').value);
    formData.append('status', this.editForm.get('status').value);
    formData.append('country_id', this.country_id);
    this.store.dispatch(new cstateActions.UpdateCstate(this.editForm.value));
  }
  handleCstateDeletion(cstateId){
    this.store.dispatch(new cstateActions.DeleteCstate(cstateId));
  }

}
