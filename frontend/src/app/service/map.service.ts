import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
import {Router} from '@angular/router';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class MapService {

  public token: string;
  private headers: HttpHeaders;
  private readonly apiUrl = environment.apiUrl;
  private readonly baseUrl = environment.baseUrl;

  constructor(private http: HttpClient, private router: Router) {
    var currentUser = JSON.parse(localStorage.getItem('user'));
    this.token = currentUser.token;
  }
  
  public getCords(zoneId: any): Observable<any> {
    const httpOptions = {
        headers: new HttpHeaders({
          "Content-Type": 'application/json',
          "Access-Control-Allow-Origin": "*",
          "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
          "Authorization" : "Bearer " + this.token
        })
      };
    return this.http.get(this.apiUrl  + '/getCords/' + zoneId, httpOptions )
        .pipe(
            map((response: Response) => {
                return response;
            })
        );
   }

   public updateCords(coords: any, zone_id:any): Observable<any> {
    const httpOptions = {
        headers: new HttpHeaders({
          "Content-Type": 'application/json',
          "Access-Control-Allow-Origin": "*",
          "Access-Control-Allow-Headers": "Origin, Authorization, Content-Type, Accept",
          "Authorization" : "Bearer " + this.token
        })
      };
    return this.http.get(this.apiUrl  + '/updateCords?coords=' + coords + '&zone_id=' + zone_id , httpOptions )
        .pipe(
            map((response: Response) => {
                return response;
            })
        );
   }
}
