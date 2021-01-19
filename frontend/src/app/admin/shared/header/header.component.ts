import { Component, Injector, OnInit } from '@angular/core';
import { AppComponentBase } from 'src/app/app-component-base';
import { AuthenticationService } from '../../../service/authentication.service';
import { ConfigService } from 'src/app/service/config.service';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent extends AppComponentBase {
  currentUser = JSON.parse(localStorage.getItem('user'));
  user_id = '';
  apiUrl = environment.apiUrl;
  currentLang = sessionStorage.languageCode;
  currentLangImage = '';
  allLangs = [];
  public token: string;
  constructor(private config: ConfigService, injector: Injector, private authService: AuthenticationService,router:Router) {
    super(injector);
   }

  ngOnInit() {
    this.config.get('fetchLanguages').subscribe((data) => {
        this.allLangs = data;
        this.allLangs.forEach(element => {
          if(this.currentLang == element.short_code){
              this.currentLangImage = element.image;
          }
        });
    });

    if(this.currentUser)
    {
      this.token =  this.currentUser.token;
      this.user_id =  this.currentUser.profile.user_id;
    }

  }
  logout(){
    this.config.post('logout', {user_id : this.user_id}).subscribe((data) => {
      localStorage.clear();
      sessionStorage.clear();
      this.router.navigate(['/accounts/login']);

    });
  }

  updateLanguage(lang){
    sessionStorage.languageCode = lang;
    this.currentLang = sessionStorage.languageCode;
    this.localization.use(lang);
    this.allLangs.forEach(element => {
      if(this.currentLang == element.short_code){
          this.currentLangImage = element.image;
      }
    });
  }

}
