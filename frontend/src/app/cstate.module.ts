import { NgModule } from '@angular/core';
import { StoreModule } from '@ngrx/store';
import { EffectsModule } from '@ngrx/effects';
import { reducer } from './store/cstate/cstate.reducer';
import { CstateEffects } from './store/cstate/cstate.effects';

@NgModule({
  imports: [
    StoreModule.forFeature('cstates', reducer),
    EffectsModule.forFeature([CstateEffects])
  ],
})
export class CstateModule { }
