import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { StoreModule } from '@ngrx/store';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { MatButtonModule, MatIconModule,
  MatCardModule, MatInputModule, MatToolbarModule } from '@angular/material';
import { routing } from './app-routing.module';
import { AuthGuard } from './_guards/auth.guard';
import { AuthenticationService } from './_services/authentication.service';
import { AppComponent } from './_components/app.component';
import { LoginComponent } from './_components/auth/index';
import { NavigationComponent } from './_components/navigation/navigation.component';
import { HomeComponent } from './_components/home/home.component';
import { reducers, metaReducers } from './store/user/reducers';
import { StoreDevtoolsModule } from '@ngrx/store-devtools';
import { environment } from '../environments/environment';
import { EffectsModule } from '@ngrx/effects';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    NavigationComponent,
    HomeComponent
  ],
  imports: [
      BrowserModule,
      FormsModule,
      MatButtonModule, 
      MatIconModule, 
      MatCardModule,
      MatInputModule,
      MatToolbarModule,
      ReactiveFormsModule,
      routing,
      HttpClientModule,
      HttpClientModule,
      StoreModule.forRoot(reducers, {
    metaReducers,
    runtimeChecks: {
      strictStateImmutability: true,
      strictActionImmutability: true,
    }
  }), !environment.production ? StoreDevtoolsModule.instrument() : [], FormsModule, ReactiveFormsModule],
  providers: [
    AuthGuard,
    AuthenticationService
  ],
  bootstrap: [AppComponent], // default component
})
export class AppModule { }
