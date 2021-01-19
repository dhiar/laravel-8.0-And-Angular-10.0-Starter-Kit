import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { AuthenticationService } from '../../service/authentication.service';
import { environment } from '../../../environments/environment';
import { ConfigService } from 'src/app/service/config.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  apiUrl = environment.apiUrl;
  email: string = '';
  password: string = '';
  email_validation: string = '';
  password_validation: string = '';
  response_error: string = '';
  errorMessage = '';
  saving= false;
    constructor(private spinner: NgxSpinnerService, public config: ConfigService, private authService: AuthenticationService, private router: Router) {}
  ngOnInit()
  {
    this.spinner.show();
    setTimeout(() => {
      this.spinner.hide();
    }, 100);
  }
  onLogIn() {
    this.email_validation= '';
    this.password_validation = '';
    this.saving=true;
    this.authService.login(this.email, this.password)
    .subscribe(res => {
        this.saving=false;
        if(res['token']){
          window.location.reload();
        }
    }, error => {
      this.saving=false;
      this.email_validation= '';
      this.password_validation = '';
      this.response_error = '';
      if(error.error.email){
       this.email_validation = error.error.email;
      }
      else if(error.error.password){
       this.password_validation = error.error.password;
      }
      else{
       this.response_error = error.error;
      }
      console.error(error.error);
    });
  }
}
