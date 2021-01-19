import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
import {Router} from '@angular/router';
import { City } from '../store/city/city.model';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CityService {

  public token: string;
  private headers: HttpHeaders;
  private readonly apiUrl = environment.apiUrl;
  private readonly baseUrl = environment.baseUrl;

  constructor(private http: HttpClient, private router: Router,) {
    var currentUser = JSON.parse(localStorage.getItem('user'));
    this.token = currentUser && currentUser.token;
  }
  
  public getAllCities(): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get(this.apiUrl  + '/fetchCities', httpOptions)
        .pipe(
            map((response: Response) => {
                return response;
            })
        );
}

public fetchCitiesByState(stateId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCitiesByState/' + stateId, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public fetchCitiesByCountry(countryId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCitiesByCountry/' + countryId, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public getCitiesByPage(pageNumber: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCities?page=' + pageNumber.pageNumber + '&sorted_colum=' +pageNumber.sorted_colum+ '&data_sort_order=' +pageNumber.data_sort_order + '&searchColumn=' +pageNumber.searchColumn + '&searchText=' + pageNumber.searchText, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public fetchDataToEdit(cityId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchCityById/' + cityId, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

  public getCity(cityId: number): Observable<City> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<City>(this.apiUrl + '/getCityById' + cityId);
  }

  public updateCity(city: City): Observable<City> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<City>(this.apiUrl + '/updateCity', city, httpOptions);
  }

  public addNewCity(city: City): Observable<City> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<City>(this.apiUrl  + '/addCity', city, httpOptions);
  }

  public deleteCity(cityId: number): Observable<City> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<City>(this.apiUrl  +  '/deleteCity/' + cityId, httpOptions);
  }
}
