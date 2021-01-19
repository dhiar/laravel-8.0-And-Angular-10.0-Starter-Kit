import { HttpClient } from '@angular/common/http';
import { Component, Injector, OnInit, ViewChild } from '@angular/core';
import { ColumnMode, DatatableComponent } from '@swimlane/ngx-datatable';
import { AppComponentBase } from 'src/app/app-component-base';
import { ConfigService } from 'src/app/service/config.service';

@Component({
  selector: 'app-view-user',
  templateUrl: './view-user.component.html',
  styleUrls: ['./view-user.component.scss']
})
export class ViewUserComponent extends AppComponentBase {
  @ViewChild(DatatableComponent) table: DatatableComponent;
  ColumnMode = ColumnMode;
  temp = [];
  page = new Page();
  rows = new Array<any>();
  searchColum = 'id';
  constructor(injector: Injector, private config:ConfigService) {
    super(injector);
    this.page.pageNumber = 0;
    this.page.size = this.config.pageSize;
    
   }
 
   allColumns = [
    { prop: 'role_name', name: 'Role' },
    { prop: 'first_name', name: 'First Name' },
    { prop: 'last_name', name: 'Last Name' },
    { prop: 'email', name: 'Primary Email' },
    { prop: 'country_name', name: 'Country' },
    { prop: 'phone', name: 'Phone' },
  ];
  columns = [
    { prop: 'role_name', name: 'Role' },
    { prop: 'first_name', name: 'First Name' },
    { prop: 'last_name', name: 'Last Name' },
    { prop: 'email', name: 'Primary Email' },
    { prop: 'country_name', name: 'Country' },
    { prop: 'phone', name: 'Phone' },
  ];
  ngOnInit(): void {
    this.setPage({ offset: 0 });
  }


  setPage(pageInfo) {
    this.spinnerService.show();
    this.page.pageNumber = pageInfo.offset;
    var pageNum = this.page.pageNumber + 1;
    this.config.get('FetchUser?page='+pageNum+'').subscribe((data)=>{
      this.page.totalPages = data.last_page;
      this.page.totalElements=data.total
      this.rows = data.data;
      this.spinnerService.hide();
      console.log('this.rows', this.rows);
    });
  }
  setSearchColumn(event) {
    this.searchColum = event.target.value;
  }
  searchRecord(event) {
    let searchText = event.target.value;
    if (searchText) {
      this.spinnerService.show();
      this.config.get('FetchUser?searchText=' + searchText + '&searchColum=' + this.searchColum).subscribe((data) => {
        this.page.totalPages = data.last_page;
        this.page.totalElements = data.total
        this.rows = data.data;
        this.spinnerService.hide();
      });
    }
    else {
      this.setPage({ offset: 0 });
    }
  }

  delete(id) {
    this.spinnerService.show();
    this.config.get('delete-user/' + id).subscribe((data) => {
      this.setPage({ offset: 0 });
      this.toastr.success('User Deleted Successfully!');
      this.spinnerService.hide();
    });
  }

  toggle(col) {
    const isChecked = this.isChecked(col);

    if (isChecked) {
      this.columns = this.columns.filter(c => {
        return c.name !== col.name;
      });
    } else {
      this.columns = [...this.columns, col];
    }
  }

  isChecked(col) {
    return (
      this.columns.find(c => {
        return c.name === col.name;
      }) !== undefined
    );
  }

  excelDownload(){
    this.excelService.exportAsExcelFile(this.rows, 'Users');
  }
}
export class Page {
  // The number of elements in the page
  size: number = 0;
  // The total number of elements
  totalElements: number = 0;
  // The total number of pages
  totalPages: number = 0;
  // The current page number
  pageNumber: number = 0;
}

