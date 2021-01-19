import { NgModule } from '@angular/core';
import { StoreModule } from '@ngrx/store';
import { EffectsModule } from '@ngrx/effects';
import { reducer } from './store/country/country.reducer';
import { CountryEffects } from './store/country/country.effects';

@NgModule({
  imports: [
    StoreModule.forFeature('countries', reducer),
    EffectsModule.forFeature([CountryEffects])
  ],
})
export class CountryModule { }
