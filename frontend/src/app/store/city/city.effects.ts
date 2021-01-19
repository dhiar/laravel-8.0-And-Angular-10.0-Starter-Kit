import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { CityService } from '../../service/city.service';
import { mergeMap, map, catchError } from 'rxjs/operators';
import { City } from './city.model';
import { of, Observable } from 'rxjs';
import { Action, Store } from '@ngrx/store';
import { Router } from '@angular/router';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';

import * as fromCity from './city.reducer';
import * as cityActions from './city.actions';
import { CityActionTypes } from './city.actions';

@Injectable()
export class CityEffects {
    readonly LOAD_COUNTRY_ERROR_MESSAGE = {'type' : 'load-city', 'status': 'danger', 'messsage': 'City Has Not Loaded SuccessFully!' };
    readonly CREATE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'add-city', 'status': 'success', 'messsage': 'City Has Been Created SuccessFully!' };
    readonly CREATE_COUNTRY_ERROR_MESSAGE = {'type' : 'add-error-city', 'status': 'danger', 'messsage': 'City Has Not Been Created SuccessFully!' };
    readonly DELETE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'delete-city', 'status': 'success', 'messsage': 'City Has Been Deleted SuccessFully!' };
    readonly DELETE_COUNTRY_ERROR_MESSAGE = {'type' : 'delete-city-error', 'status': 'danger', 'messsage': 'City Has Not Been Deleted SuccessFully!' };
    readonly UPDATE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'update-city', 'status': 'success', 'messsage': 'City Has Been Updated SuccessFully!' };
    readonly UPDATE_COUNTRY_ERROR_MESSAGE = {'type' : 'update-city-error', 'status': 'danger', 'messsage': 'City Has Not Been Updated SuccessFully!' };
    readonly MODAL_DATA= { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };

    constructor(private actions$: Actions,
        private cityService: CityService,
        private router: Router,
        private store: Store<fromCity.State>) { }

    @Effect()
    loadAllCities$: Observable<Action> = this.actions$.pipe(
        ofType(cityActions.CityActionTypes.LoadAllCities),
        mergeMap(() => this.cityService.getAllCities().pipe(
            map((cities: any) => new cityActions.LoadAllCitiesSuccess(cities),
            ),
            catchError(() => of(new cityActions.LoadAllCitiesFail(this.LOAD_COUNTRY_ERROR_MESSAGE)))
        ))
    );

    @Effect()
    loadCitiesByPage$: Observable<Action> = this.actions$.pipe(
        ofType(cityActions.CityActionTypes.LoadCitiesByPage),
        map((action: cityActions.LoadCitiesByPage) => action.payload),
        mergeMap((pageNumber: any) =>
            this.cityService.getCitiesByPage(pageNumber).pipe(
                map((cities: any) => {
                    return new cityActions.LoadCitiesByPageSuccess(cities);
                }),
                catchError((error) => of((new cityActions.CreateCityFail(error.error))))

            )
        )
    );

    @Effect()
    deleteCity$: Observable<Action> = this.actions$.pipe(
        ofType(cityActions.CityActionTypes.DeleteCity),
        map((action: cityActions.DeleteCity) => action.payload),
        mergeMap((cityId: number) =>
            this.cityService.deleteCity(cityId).pipe(
                map(() => {
                    this.store.dispatch(new cityActions.LoadAllCities());
                    this.store.dispatch(new cityActions.LoadCitiesByPage(this.MODAL_DATA));
                    this.store.dispatch(new cityActions.Messages(this.DELETE_COUNTRY_SUCCESS_MESSAGE))
                    return new cityActions.DeleteCitySuccess(cityId);
                }),
                catchError(() => of((new cityActions.DeleteCityFail(this.CREATE_COUNTRY_ERROR_MESSAGE)))
                )
            )));

    @Effect()
    createCity$: Observable<Action> = this.actions$.pipe(
        ofType(cityActions.CityActionTypes.CreateCity),
        map((action: cityActions.CreateCity) => action.payload),
        mergeMap((city: City) =>
            this.cityService.addNewCity(city).pipe(
                map(() => {
                    this.store.dispatch(new cityActions.LoadAllCities());
                    this.store.dispatch(new cityActions.LoadCitiesByPage(this.MODAL_DATA));
                    this.store.dispatch(new cityActions.Messages(this.CREATE_COUNTRY_SUCCESS_MESSAGE))
                    return new cityActions.CreateCitySuccess(city);
                }),
                catchError((error) => of((new cityActions.CreateCityFail(error.error))))

            )
        )
    );

    @Effect()
    updateCity$: Observable<Action> = this.actions$.pipe(
        ofType(cityActions.CityActionTypes.UpdateCity),
        map((action: cityActions.UpdateCity) => action.payload),
        mergeMap((city: City) =>
            this.cityService.updateCity(city).pipe(
                map(updatedCity => {
                    // this.router.navigate(['/']);
                    this.store.dispatch(new cityActions.LoadAllCities());
                    this.store.dispatch(new cityActions.LoadCitiesByPage(this.MODAL_DATA));
                    this.store.dispatch(new cityActions.Messages(this.UPDATE_COUNTRY_SUCCESS_MESSAGE))
                    return new cityActions.UpdateCitySuccess(updatedCity);
                }),
                catchError((error) => of((new cityActions.CreateCityFail(error.error)))
                )
            )));
}
