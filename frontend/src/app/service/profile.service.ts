import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from '../../environments/environment';

@Injectable()
export class ProfileService {
    public token: string;
    public currentUser_data: any;
    private headers: HttpHeaders;
    private readonly apiUrl = environment.apiUrl;
    private readonly baseUrl = environment.baseUrl;

    constructor(private http: HttpClient) {
        //append headers
        this.headers = new HttpHeaders();
        this.headers.append("Content-Type", 'multipart/form-data');
        this.headers.append("Access-Control-Allow-Origin", "*");
        this.headers.append("Access-Control-Allow-Headers", "Origin, Authorization, Content-Type, Accept");
        
        // set token if saved in local storage
        var currentUser = JSON.parse(localStorage.getItem('user'));
        this.currentUser_data = JSON.parse(localStorage.getItem('user'))
        this.token = currentUser && currentUser.token;
        console.log(this.token);
    }

    updateProfile(requestParams): Observable<any> {
        return this.http.post(this.apiUrl+'/updateProfile', requestParams, { headers:this.headers } )
            .pipe(
                map((response: Response) => {
                    console.log(response);
                    return response;
                })
            );
    }

}