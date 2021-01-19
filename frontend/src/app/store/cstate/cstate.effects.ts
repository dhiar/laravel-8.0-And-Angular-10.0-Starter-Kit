import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { CstateService } from '../../service/cstate.service';
import { mergeMap, map, catchError } from 'rxjs/operators';
import { Cstate } from './cstate.model';
import { of, Observable } from 'rxjs';
import { Action, Store } from '@ngrx/store';
import { Router } from '@angular/router';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';

import * as fromCstate from './cstate.reducer';
import * as cstateActions from './cstate.actions';
import { CstateActionTypes } from './cstate.actions';

@Injectable()
export class CstateEffects {
    readonly LOAD_COUNTRY_ERROR_MESSAGE = {'type' : 'load-state', 'status': 'danger', 'messsage': 'Cstate Has Not Loaded SuccessFully!' };
    readonly CREATE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'add-state', 'status': 'success', 'messsage': 'Cstate Has Been Created SuccessFully!' };
    readonly CREATE_COUNTRY_ERROR_MESSAGE = {'type' : 'add-error-state', 'status': 'danger', 'messsage': 'Cstate Has Not Been Created SuccessFully!' };
    readonly DELETE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'delete-state', 'status': 'success', 'messsage': 'Cstate Has Been Deleted SuccessFully!' };
    readonly DELETE_COUNTRY_ERROR_MESSAGE = {'type' : 'delete-error-state', 'status': 'danger', 'messsage': 'Cstate Has Not Been Deleted SuccessFully!' };
    readonly UPDATE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'update-state', 'status': 'success', 'messsage': 'Cstate Has Been Updated SuccessFully!' };
    readonly UPDATE_COUNTRY_ERROR_MESSAGE = {'type' : 'update-error-state', 'status': 'danger', 'messsage': 'Cstate Has Not Been Updated SuccessFully!' };
    readonly MODAL_DATA= { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };

    constructor(private actions$: Actions,
        private cstateService: CstateService,
        private router: Router,
        private store: Store<fromCstate.State>) { }

    @Effect()
    loadAllCstates$: Observable<Action> = this.actions$.pipe(
        ofType(cstateActions.CstateActionTypes.LoadAllCstates),
        mergeMap(() => this.cstateService.getAllCstates().pipe(
            map((cstates: any) => new cstateActions.LoadAllCstatesSuccess(cstates),
            ),
            catchError(() => of(new cstateActions.LoadAllCstatesFail(this.LOAD_COUNTRY_ERROR_MESSAGE)))
        ))
    );

    @Effect()
    loadCstatesByPage$: Observable<Action> = this.actions$.pipe(
        ofType(cstateActions.CstateActionTypes.LoadCstatesByPage),
        map((action: cstateActions.LoadCstatesByPage) => action.payload),
        mergeMap((pageNumber: any) =>
            this.cstateService.getCstatesByPage(pageNumber).pipe(
                map((cstates: any) => {
                    return new cstateActions.LoadCstatesByPageSuccess(cstates);
                }),
                catchError((error) => of((new cstateActions.CreateCstateFail(error.error))))

            )
        )
    );

    @Effect()
    deleteCstate$: Observable<Action> = this.actions$.pipe(
        ofType(cstateActions.CstateActionTypes.DeleteCstate),
        map((action: cstateActions.DeleteCstate) => action.payload),
        mergeMap((cstateId: number) =>
            this.cstateService.deleteCstate(cstateId).pipe(
                map(() => {
                    this.store.dispatch(new cstateActions.LoadAllCstates());
                    this.store.dispatch(new cstateActions.LoadCstatesByPage(this.MODAL_DATA));
                    this.store.dispatch(new cstateActions.Messages(this.DELETE_COUNTRY_SUCCESS_MESSAGE))
                    return new cstateActions.DeleteCstateSuccess(cstateId);
                }),
                catchError(() => of((new cstateActions.DeleteCstateFail(this.CREATE_COUNTRY_ERROR_MESSAGE)))
                )
            )));

    @Effect()
    createCstate$: Observable<Action> = this.actions$.pipe(
        ofType(cstateActions.CstateActionTypes.CreateCstate),
        map((action: cstateActions.CreateCstate) => action.payload),
        mergeMap((cstate: Cstate) =>
            this.cstateService.addNewCstate(cstate).pipe(
                map(() => {
                    this.store.dispatch(new cstateActions.LoadAllCstates());
                    this.store.dispatch(new cstateActions.LoadCstatesByPage(this.MODAL_DATA));
                    this.store.dispatch(new cstateActions.Messages(this.CREATE_COUNTRY_SUCCESS_MESSAGE))
                    return new cstateActions.CreateCstateSuccess(cstate);
                }),
                catchError((error) => of((new cstateActions.CreateCstateFail(error.error))))

            )
        )
    );

    @Effect()
    updateCstate$: Observable<Action> = this.actions$.pipe(
        ofType(cstateActions.CstateActionTypes.UpdateCstate),
        map((action: cstateActions.UpdateCstate) => action.payload),
        mergeMap((cstate: Cstate) =>
            this.cstateService.updateCstate(cstate).pipe(
                map(updatedCstate => {
                    // this.router.navigate(['/']);
                    this.store.dispatch(new cstateActions.LoadAllCstates());
                    this.store.dispatch(new cstateActions.LoadCstatesByPage(this.MODAL_DATA));
                    this.store.dispatch(new cstateActions.Messages(this.UPDATE_COUNTRY_SUCCESS_MESSAGE))
                    return new cstateActions.UpdateCstateSuccess(updatedCstate);
                }),
                catchError((error) => of((new cstateActions.CreateCstateFail(error.error)))
                )
            )));
}
