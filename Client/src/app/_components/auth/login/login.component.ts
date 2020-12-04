import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../../_services/authentication.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

   email: string = '';
   password: string = '';
   email_validation: string = '';
   password_validation: string = '';
   response_error: string = '';

  constructor(private authService: AuthenticationService, private router: Router) { 
  }

  ngOnInit() {
  }

  onLogIn() {
    this.authService.login(this.email, this.password)
    .subscribe(res => {
        this.router.navigate(['home']);
    }, error => {
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
