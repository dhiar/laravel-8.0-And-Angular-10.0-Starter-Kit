import { Component, Injector, OnInit } from '@angular/core';
import { AppComponentBase } from 'src/app/app-component-base';
// import { SharedModule } from '../../../SharedModule.module';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent extends AppComponentBase {
  constructor(injector: Injector) {
    super(injector);
   }
  ngOnInit(): void {
  }

}
