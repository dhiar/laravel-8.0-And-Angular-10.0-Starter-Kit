import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
import {Router} from '@angular/router';
import { Country } from '../store/country/country.model';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CountryService {

  public token: string;
  private headers: HttpHeaders;
  private readonly apiUrl = environment.apiUrl;
  private readonly baseUrl = environment.baseUrl;

  constructor(private http: HttpClient, private router: Router,) {
      var currentUser = JSON.parse(localStorage.getItem('user'));
      this.token = currentUser && currentUser.token;
  }
  
  public getAllCountries(): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };

    return this.http.get(this.apiUrl  + '/fetchCountries', httpOptions )
        .pipe(
            map((response: Response) => {
                return response;
            })
        );
}

public getCountriesByPage(pageNumber: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCountries?page=' + pageNumber.pageNumber + '&sorted_colum=' +pageNumber.sorted_colum+ '&data_sort_order=' +pageNumber.data_sort_order + '&searchColumn=' +pageNumber.searchColumn + '&searchText=' + pageNumber.searchText, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public fetchDataToEdit(countryId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCountryById/' + countryId, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

  public getCountry(countryId: number): Observable<Country> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<Country>(this.apiUrl + '/getCountryById' + countryId, httpOptions);
  }

  public updateCountry(country: Country): Observable<Country> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<Country>(this.apiUrl + '/updateCountry', country, httpOptions);
  }

  public addNewCountry(country: Country): Observable<Country> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Accept': '*/*',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<Country>(this.apiUrl  + '/addCountry', country, httpOptions);
  }

  public deleteCountry(countryId: number): Observable<Country> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<Country>(this.apiUrl  +  '/deleteCountry/' + countryId, httpOptions);
  }
}
