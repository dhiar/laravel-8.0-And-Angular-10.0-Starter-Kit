import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
import {Router} from '@angular/router';
import { Zone } from '../store/zone/zone.model';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ZoneService {

  public token: string;
  private headers: HttpHeaders;
  private readonly apiUrl = environment.apiUrl;
  private readonly baseUrl = environment.baseUrl;

  constructor(private http: HttpClient, private router: Router,) {
    var currentUser = JSON.parse(localStorage.getItem('user'));

    if(currentUser)
    {this.token = currentUser.token;}
    else{
      this.router.navigate(["/accounts/login"])
    }

  }
  
  public getAllZones(): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get(this.apiUrl  + '/fetchZones', httpOptions )
        .pipe(
            map((response: Response) => {
                return response;
            })
        );
}

public getZonesByPage(pageNumber: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchZones?page=' + pageNumber.pageNumber + '&sorted_colum=' +pageNumber.sorted_colum+ '&data_sort_order=' +pageNumber.data_sort_order + '&searchColumn=' +pageNumber.searchColumn + '&searchText=' + pageNumber.searchText, httpOptions )
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public getStatesByCountry(zoneId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/getStatesByCountry/' + zoneId, httpOptions)
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

public fetchDataToEdit(zoneId: any): Observable<any> {
  const httpOptions = {
    headers: new HttpHeaders({
      "Content-Type": 'application/json',
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
      "Authorization" : "Bearer " + this.token
    })
  };
  return this.http.get(this.apiUrl  + '/fetchZoneById/' + zoneId, httpOptions)
      .pipe(
          map((response: Response) => {
              return response;
          })
      );
}

  public getZone(zoneId: number): Observable<Zone> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<Zone>(this.apiUrl + '/getZoneById' + zoneId, httpOptions);
  }

  public updateZone(zone: Zone): Observable<Zone> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<Zone>(this.apiUrl + '/updateZone', zone, httpOptions);
  }

  public addNewZone(zone: Zone): Observable<Zone> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.post<Zone>(this.apiUrl  + '/addZone', zone, httpOptions);
  }

  public deleteZone(zoneId: number): Observable<Zone> {
    const httpOptions = {
      headers: new HttpHeaders({
        "Content-Type": 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
        "Authorization" : "Bearer " + this.token
      })
    };
    return this.http.get<Zone>(this.apiUrl  +  '/deleteZone/' + zoneId, httpOptions);
  }
}
