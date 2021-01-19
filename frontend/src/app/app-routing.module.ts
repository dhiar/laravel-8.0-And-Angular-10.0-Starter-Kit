import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { RoleGuard } from './service/role-guard.service';
const routes: Routes = [
 { path: '', redirectTo: 'accounts', pathMatch: 'full' },
 {
  path: 'accounts',
  loadChildren: () => import('./accounts/accounts.module').then(m => m.AccountsModule),
  data: { preload: true }
},
{
  path: 'admin',
  loadChildren: () => import('./admin/admin.module').then(m => m.AdminModule),
 // data: { preload: true }
  canActivate: [RoleGuard],
  data: {role: 'Admin'}
},
{
  path: '**',
  redirectTo: ''
},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
