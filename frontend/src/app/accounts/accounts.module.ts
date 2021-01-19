import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthenticationService } from '../service/authentication.service';
import { AccountsRoutingModule } from './accounts-routing.module';
import { LoginComponent } from './login/login.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { SharedModule } from '../SharedModule.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NotAuthGuard } from '../service/not-auth-guard.service';


@NgModule({
  declarations: [LoginComponent, ForgotPasswordComponent],
  imports: [
    CommonModule,
    AccountsRoutingModule,
    SharedModule,
    FormsModule,
    ReactiveFormsModule
    ],
  providers: [
    AuthenticationService,
    NotAuthGuard
  ],
  //bootstrap: [LoginComponent]
})
export class AccountsModule { }
