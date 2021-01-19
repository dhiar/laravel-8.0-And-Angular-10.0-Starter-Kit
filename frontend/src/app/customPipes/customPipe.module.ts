// application-pipes.module.ts
// other imports
import { NgModule } from '@angular/core';
import { CurrencySymbolPipe } from './currency.pipe';

@NgModule({
  imports: [
    // dep modules
  ],
  declarations: [ 
    CurrencySymbolPipe
  ],
  exports: [
    CurrencySymbolPipe
  ]
})
export class ApplicationPipesModule {}