import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
import {Router} from '@angular/router';
import { Cstate } from '../store/cstate/cstate.model';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CstateService {

  public token: string;
  private headers: HttpHeaders;
  private readonly apiUrl = environment.apiUrl;
  private readonly baseUrl = environment.baseUrl;

  constructor(private http: HttpClient, private router: Router,) {
    var currentUser = JSON.parse(localStorage.getItem('user'));
    this.token = currentUser && currentUser.token;
  }
  
  public getAllCstates(): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get(this.apiUrl  + '/fetchCstates', { headers: this.headers } )
        .pipe(
            map((response: Response) => {
                return response;
            })
        );
}

public getCstatesByPage(pageNumber: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCstates?page=' + pageNumber.pageNumber + '&sorted_colum=' +pageNumber.sorted_colum+ '&data_sort_order=' +pageNumber.data_sort_order + '&searchColumn=' +pageNumber.searchColumn + '&searchText=' + pageNumber.searchText, httpOptions)
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public getStatesByCountry(cstateId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/getStatesByCountry/' + cstateId, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public fetchDataToEdit(cstateId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCstateById/' + cstateId, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

  public getCstate(cstateId: number): Observable<Cstate> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<Cstate>(this.apiUrl + '/getCstateById' + cstateId, httpOptions);
  }

  public updateCstate(cstate: Cstate): Observable<Cstate> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<Cstate>(this.apiUrl + '/updateCstate', cstate, httpOptions);
  }

  public addNewCstate(cstate: Cstate): Observable<Cstate> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<Cstate>(this.apiUrl  + '/addCstate', cstate, httpOptions);
  }

  public deleteCstate(cstateId: number): Observable<Cstate> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<Cstate>(this.apiUrl  +  '/deleteCstate/' + cstateId, httpOptions);
  }
}
