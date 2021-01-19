import { Injectable } from "@angular/core";
import { Router } from "@angular/router";

@Injectable()
export class PermissionCheckerService  {
  constructor(private _router: Router) {
  }
  isGranted(permissionName: string): boolean {
    return true
  }
}