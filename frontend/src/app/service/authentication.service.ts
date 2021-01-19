import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import {Router} from '@angular/router';

@Injectable()
export class AuthenticationService {
    public token: string;
    public ipAddress:string;
    private headers: HttpHeaders;
    private readonly apiUrl = environment.apiUrl;
    private readonly baseUrl = environment.baseUrl;
    user_id = '';

    constructor(private http: HttpClient, private router: Router,) {
        //append headers
        // set token if saved in local storage
        var currentUser = JSON.parse(localStorage.getItem('user'));
        this.token = currentUser && currentUser.token;
        if(this.token){
          this.user_id = currentUser.profile.user_id;
        }
        this.getIP();


    }

    login(email: string, password: string): Observable<any> {
        this.headers = new HttpHeaders();
        this.headers.append("Content-Type", 'application/json');
        this.headers.append("Access-Control-Allow-Origin", "*");
        this.headers.append("Access-Control-Allow-Headers", "Origin, Authorization, Content-Type, Accept");
        return this.http.post(this.apiUrl+'/login', { email: email, password: password, ip: this.ipAddress }, { headers: this.headers } )
            .pipe(
                map((response: Response) => {
                    this.token = response['token'];
                    let email = response['email'];
                    if (this.token) {
                        localStorage.setItem('user',
                            JSON.stringify({ email: email, token: this.token, profile: response['profile'], info : response['ip_info'], permissions: response['permissions']}));
                    }
                    return response;
                })
            );
    }
    getIP()
    {
        this.http.get("http://api.ipify.org/?format=json").subscribe((res:any)=>{
        this.ipAddress=res.ip;
      });
    }

}
