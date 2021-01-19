import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { ZoneService } from '../../service/zone.service';
import { mergeMap, map, catchError } from 'rxjs/operators';
import { Zone } from './zone.model';
import { of, Observable } from 'rxjs';
import { Action, Store } from '@ngrx/store';
import { Router } from '@angular/router';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';

import * as fromZone from './zone.reducer';
import * as zoneActions from './zone.actions';
import { ZoneActionTypes } from './zone.actions';

@Injectable()
export class ZoneEffects {
    readonly LOAD_COUNTRY_ERROR_MESSAGE = { 'status': 'danger', 'messsage': 'Zone Has Not Loaded SuccessFully!' };
    readonly CREATE_COUNTRY_SUCCESS_MESSAGE = { 'status': 'success', 'messsage': 'Zone Has Been Created SuccessFully!' };
    readonly CREATE_COUNTRY_ERROR_MESSAGE = { 'status': 'danger', 'messsage': 'Zone Has Not Been Created SuccessFully!' };
    readonly DELETE_COUNTRY_SUCCESS_MESSAGE = { 'status': 'success', 'messsage': 'Zone Has Been Deleted SuccessFully!' };
    readonly DELETE_COUNTRY_ERROR_MESSAGE = { 'status': 'danger', 'messsage': 'Zone Has Not Been Deleted SuccessFully!' };
    readonly UPDATE_COUNTRY_SUCCESS_MESSAGE = { 'status': 'success', 'messsage': 'Zone Has Been Updated SuccessFully!' };
    readonly UPDATE_COUNTRY_ERROR_MESSAGE = { 'status': 'danger', 'messsage': 'Zone Has Not Been Updated SuccessFully!' };
    readonly MODAL_DATA= { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };

    constructor(private actions$: Actions,
        private zoneService: ZoneService,
        private router: Router,
        private store: Store<fromZone.State>) { }

    @Effect()
    loadAllZones$: Observable<Action> = this.actions$.pipe(
        ofType(zoneActions.ZoneActionTypes.LoadAllZones),
        mergeMap(() => this.zoneService.getAllZones().pipe(
            map((zones: any) => new zoneActions.LoadAllZonesSuccess(zones),
            ),
            catchError(() => of(new zoneActions.LoadAllZonesFail(this.LOAD_COUNTRY_ERROR_MESSAGE)))
        ))
    );

    @Effect()
    loadZonesByPage$: Observable<Action> = this.actions$.pipe(
        ofType(zoneActions.ZoneActionTypes.LoadZonesByPage),
        map((action: zoneActions.LoadZonesByPage) => action.payload),
        mergeMap((pageNumber: any) =>
            this.zoneService.getZonesByPage(pageNumber).pipe(
                map((zones: any) => {
                    return new zoneActions.LoadZonesByPageSuccess(zones);
                }),
                catchError((error) => of((new zoneActions.CreateZoneFail(error.error))))

            )
        )
    );

    @Effect()
    deleteZone$: Observable<Action> = this.actions$.pipe(
        ofType(zoneActions.ZoneActionTypes.DeleteZone),
        map((action: zoneActions.DeleteZone) => action.payload),
        mergeMap((zoneId: number) =>
            this.zoneService.deleteZone(zoneId).pipe(
                map(() => {
                    this.store.dispatch(new zoneActions.LoadAllZones());
                    this.store.dispatch(new zoneActions.LoadZonesByPage(this.MODAL_DATA));
                    this.store.dispatch(new zoneActions.Messages(this.DELETE_COUNTRY_SUCCESS_MESSAGE))
                    return new zoneActions.DeleteZoneSuccess(zoneId);
                }),
                catchError(() => of((new zoneActions.DeleteZoneFail(this.CREATE_COUNTRY_ERROR_MESSAGE)))
                )
            )));

    @Effect()
    createZone$: Observable<Action> = this.actions$.pipe(
        ofType(zoneActions.ZoneActionTypes.CreateZone),
        map((action: zoneActions.CreateZone) => action.payload),
        mergeMap((zone: Zone) =>
            this.zoneService.addNewZone(zone).pipe(
                map(() => {
                    this.store.dispatch(new zoneActions.LoadAllZones());
                    this.store.dispatch(new zoneActions.LoadZonesByPage(this.MODAL_DATA));
                    this.store.dispatch(new zoneActions.Messages(this.CREATE_COUNTRY_SUCCESS_MESSAGE))
                    return new zoneActions.CreateZoneSuccess(zone);
                }),
                catchError((error) => of((new zoneActions.CreateZoneFail(error.error))))

            )
        )
    );

    @Effect()
    updateZone$: Observable<Action> = this.actions$.pipe(
        ofType(zoneActions.ZoneActionTypes.UpdateZone),
        map((action: zoneActions.UpdateZone) => action.payload),
        mergeMap((zone: Zone) =>
            this.zoneService.updateZone(zone).pipe(
                map(updatedZone => {
                    // this.router.navigate(['/']);
                    this.store.dispatch(new zoneActions.LoadAllZones());
                    this.store.dispatch(new zoneActions.LoadZonesByPage(this.MODAL_DATA));
                    this.store.dispatch(new zoneActions.Messages(this.UPDATE_COUNTRY_SUCCESS_MESSAGE))
                    return new zoneActions.UpdateZoneSuccess(updatedZone);
                }),
                catchError((error) => of((new zoneActions.CreateZoneFail(error.error)))
                )
            )));
}
