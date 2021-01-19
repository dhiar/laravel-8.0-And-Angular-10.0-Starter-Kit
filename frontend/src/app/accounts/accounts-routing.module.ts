import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { LoginComponent } from './login/login.component';
import { AuthGuard } from '../service/auth-guard.service';



const routes: Routes = [
  {path: '', component: LoginComponent,
    children: [
      { path: '', redirectTo: 'login', pathMatch:'full',canActivate: [AuthGuard]},
      { path: 'login', component: LoginComponent,canActivate: [AuthGuard]},
      { path: 'forgot-password', component: ForgotPasswordComponent},
    ]
  },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AccountsRoutingModule { }
