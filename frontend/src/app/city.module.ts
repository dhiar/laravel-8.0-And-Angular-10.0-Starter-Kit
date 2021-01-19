import { NgModule } from '@angular/core';
import { StoreModule } from '@ngrx/store';
import { EffectsModule } from '@ngrx/effects';
import { reducer } from './store/city/city.reducer';
import { CityEffects } from './store/city/city.effects';

@NgModule({
  imports: [
    StoreModule.forFeature('cities', reducer),
    EffectsModule.forFeature([CityEffects])
  ],
})
export class CityModule { }
