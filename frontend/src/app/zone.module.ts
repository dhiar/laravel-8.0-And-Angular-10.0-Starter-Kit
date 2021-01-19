import { NgModule } from '@angular/core';
import { StoreModule } from '@ngrx/store';
import { EffectsModule } from '@ngrx/effects';
import { reducer } from './store/zone/zone.reducer';
import { ZoneEffects } from './store/zone/zone.effects';

@NgModule({
  imports: [
    StoreModule.forFeature('zones', reducer),
    EffectsModule.forFeature([ZoneEffects])
  ],
})
export class ZoneModule { }
