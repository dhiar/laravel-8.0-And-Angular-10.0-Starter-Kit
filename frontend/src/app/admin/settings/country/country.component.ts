import { Component, Input, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { CountryService } from '../../../service/country.service';
import { Store, select } from '@ngrx/store';
import * as fromCountry from '../../../store/country/country.reducer';
import * as countryActions from '../../../store/country/country.actions';
import { ConfigService } from 'src/app/service/config.service';
import { ToastrService } from 'ngx-toastr';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from "ngx-spinner";
import {TranslateService} from '@ngx-translate/core';


@Component({
  selector: 'app-country',
  templateUrl: './country.component.html',
  styleUrls: ['./country.component.scss']
})
export class CountryComponent implements OnInit {
  apiUrl = environment.apiUrl;
  uploadForm: FormGroup;
  editForm: FormGroup;
  countries:[] = [];
  currencies:[] = [];
  languages:[] = [];
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


  constructor(private config :ConfigService, private translate: TranslateService, private spinner: NgxSpinnerService, private countryService: CountryService, private toastr: ToastrService, private formBuilder: FormBuilder, private store: Store<fromCountry.State>) {
  }

   ngOnInit() {
    var currentUser = JSON.parse(localStorage.getItem('user'));
    console.log(currentUser.token);
    this.translate.use('en');
    this.uploadForm = this.formBuilder.group({
      id: '',
      name: '',
      code: '',
      wrench_time: '',
      language_id: '',
      currency_id: '',
      is_active: '',
      country_flag: []
    });
    this.editForm = this.formBuilder.group({
      id: '',
      name: '',
      code: '',
      wrench_time: '',
      language_id: '',
      currency_id: '',
      is_active: '',
      country_flag: []
    });
    this.config.get('fetchcurrency').subscribe((data) => {
      this.currencies = data;
    });
    this.config.get('fetchLanguages').subscribe((data) => {
      this.languages = data;
    });
    this.store.dispatch(new countryActions.LoadCountriesByPage({ 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' }));
    this.error$ = this.store.pipe(select(fromCountry.getError));
    this.store.select(fromCountry.getCountriesByPage).subscribe(
      (data) => {
        console.log(data);
        this.spinner.show();
        this.countries = data.data;
        this.paginate_links = data.links;
        this.prev_page_url = data.prev_page_url;
        this.next_page_url = data.next_page_url;
        this.spinner.hide();
      }
    );
    this.store.select(fromCountry.getMessage).subscribe(
      (dataa) => {
        this.message_for_toast = dataa.messsage;
        this.message_status = dataa.status;
        if (this.message_status == 'success') {
          this.uploadForm.get('name').setValue('');
          this.uploadForm.get('code').setValue('');
          this.uploadForm.get('wrench_time').setValue('');
          this.uploadForm.get('language_id').setValue('');
          this.uploadForm.get('currency_id').setValue('');
          this.uploadForm.get('is_active').setValue('');
          this.uploadForm.get('country_flag').setValue('');
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
  isPrevious(val): boolean { return val === '&laquo; Previous'; }
  isNext(val): boolean { return val === 'Next &raquo;'; }
  previousPage(pageNumber) {
    var pageNumber = pageNumber.split("=", 3);
    let obj = { 'pageNumber': pageNumber[1], 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new countryActions.LoadCountriesByPage(obj));
  }
  pageNumber(pageNumber) {
    let obj = { 'pageNumber': pageNumber, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new countryActions.LoadCountriesByPage(obj));
  }
  nextPage(pageNumber) {
    var pageNumber = pageNumber.split("=", 3);
    let obj = { 'pageNumber': pageNumber[1], 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };
    this.store.dispatch(new countryActions.LoadCountriesByPage(obj));
  }
  sortData(colum) {
    let obj = { 'pageNumber': this.pageNumberdefault, 'data_sort_order': this.data_sort_order, 'sorted_colum': colum, 'searchColumn': '', 'searchText': '' };
    if (this.data_sort_order == 'ASC') {
      this.store.dispatch(new countryActions.LoadCountriesByPage(obj));
      this.data_sort_order = 'DESC';
    }
    else {
      this.store.dispatch(new countryActions.LoadCountriesByPage(obj));
      this.data_sort_order = 'ASC';
    }
  }
  updateSearchColumnValue(e) {
    this.search_column = e;
  }
  searchData(e) {
    if (this.search_column != '') {
      let obj = { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': this.search_column, 'searchText': e };
      this.store.dispatch(new countryActions.LoadCountriesByPage(obj));
    }
  }
  onFileSelect(event) {
    if (event.target.files.length > 0) {
      const file = event.target.files[0];
      this.uploadForm.get('country_flag').setValue(file);
    }
  }
  onFileSelectEdit(event) {
    if (event.target.files.length > 0) {
      const file = event.target.files[0];
      this.editForm.get('country_flag').setValue(file);
    }
  }
  submitForm() {
    this.spinner.show();
    this.store.dispatch(new countryActions.CreateCountry(this.uploadForm.value));
    this.spinner.hide();

  }
  fetchDataToEdit(id) {

    this.countryService.fetchDataToEdit(id).subscribe(
      (data) => {
        console.log(data);
        this.editForm.get('id').setValue(data.countries.id);
        this.editForm.get('name').setValue(data.countries.name);
        this.editForm.get('code').setValue(data.countries.code);
        this.editForm.get('wrench_time').setValue(data.countries.wrench_time);
        this.editForm.get('language_id').setValue(data.countries.language_id);
        this.editForm.get('currency_id').setValue(data.countries.currency_id);
        this.editForm.get('is_active').setValue(data.countries.is_active);
        this.editForm.get('country_flag').setValue(data.countries.country_flag);
      }
    );
  }
  submitEditForm() {
    this.spinner.show();
    const formData = new FormData();
    this.store.dispatch(new countryActions.UpdateCountry(this.editForm.value));
  }
  handleCountryDeletion(countryId){
    this.store.dispatch(new countryActions.DeleteCountry(countryId));
  }

}
