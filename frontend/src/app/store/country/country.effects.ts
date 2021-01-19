import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { CountryService } from '../../service/country.service';
import { mergeMap, map, catchError } from 'rxjs/operators';
import { Country } from './country.model';
import { of, Observable } from 'rxjs';
import { Action, Store } from '@ngrx/store';
import { Router } from '@angular/router';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';

import * as fromCountry from './country.reducer';
import * as countryActions from './country.actions';
import { CountryActionTypes } from './country.actions';

@Injectable()
export class CountryEffects {
    readonly LOAD_COUNTRY_ERROR_MESSAGE = { 'type' : 'load-country', 'status': 'danger', 'messsage': 'Country Has Not Loaded SuccessFully!' };
    readonly CREATE_COUNTRY_SUCCESS_MESSAGE = {'type' : 'add-country', 'status': 'success', 'messsage': 'Country Has Been Created SuccessFully!' };
    readonly CREATE_COUNTRY_ERROR_MESSAGE = {'type' : 'add-error-country','status': 'danger', 'messsage': 'Country Has Not Been Created SuccessFully!' };
    readonly DELETE_COUNTRY_SUCCESS_MESSAGE = { 'type' : 'delete-country','status': 'success', 'messsage': 'Country Has Been Deleted SuccessFully!' };
    readonly DELETE_COUNTRY_ERROR_MESSAGE = { 'type' : 'delete-error-country','status': 'danger', 'messsage': 'Country Has Not Been Deleted SuccessFully!' };
    readonly UPDATE_COUNTRY_SUCCESS_MESSAGE = { 'type' : 'update-country','status': 'success', 'messsage': 'Country Has Been Updated SuccessFully!' };
    readonly UPDATE_COUNTRY_ERROR_MESSAGE = { 'type' : 'update-error-country','status': 'danger', 'messsage': 'Country Has Not Been Updated SuccessFully!' };
    readonly MODAL_DATA= { 'pageNumber': 1, 'data_sort_order': '', 'sorted_colum': '', 'searchColumn': '', 'searchText': '' };

    constructor(private actions$: Actions,
        private countryService: CountryService,
        private router: Router,
        private store: Store<fromCountry.State>) { }

    @Effect()
    loadAllCountries$: Observable<Action> = this.actions$.pipe(
        ofType(countryActions.CountryActionTypes.LoadAllCountries),
        mergeMap(() => this.countryService.getAllCountries().pipe(
            map((countries: any) => new countryActions.LoadAllCountriesSuccess(countries),
            ),
            catchError(() => of(new countryActions.LoadAllCountriesFail(this.LOAD_COUNTRY_ERROR_MESSAGE)))
        ))
    );

    @Effect()
    loadCountriesByPage$: Observable<Action> = this.actions$.pipe(
        ofType(countryActions.CountryActionTypes.LoadCountriesByPage),
        map((action: countryActions.LoadCountriesByPage) => action.payload),
        mergeMap((pageNumber: any) =>
            this.countryService.getCountriesByPage(pageNumber).pipe(
                map((countries: any) => {
                    return new countryActions.LoadCountriesByPageSuccess(countries);
                }),
                catchError((error) => of((new countryActions.CreateCountryFail(error.error))))

            )
        )
    );

    @Effect()
    deleteCountry$: Observable<Action> = this.actions$.pipe(
        ofType(countryActions.CountryActionTypes.DeleteCountry),
        map((action: countryActions.DeleteCountry) => action.payload),
        mergeMap((countryId: number) =>
            this.countryService.deleteCountry(countryId).pipe(
                map(() => {
                    this.store.dispatch(new countryActions.LoadAllCountries());
                    this.store.dispatch(new countryActions.LoadCountriesByPage(this.MODAL_DATA));
                    this.store.dispatch(new countryActions.Messages(this.DELETE_COUNTRY_SUCCESS_MESSAGE))
                    return new countryActions.DeleteCountrySuccess(countryId);
                }),
                catchError(() => of((new countryActions.DeleteCountryFail(this.CREATE_COUNTRY_ERROR_MESSAGE)))
                )
            )));

    @Effect()
    createCountry$: Observable<Action> = this.actions$.pipe(
        ofType(countryActions.CountryActionTypes.CreateCountry),
        map((action: countryActions.CreateCountry) => action.payload),
        mergeMap((country: Country) =>
            this.countryService.addNewCountry(country).pipe(
                map(() => {
                    this.store.dispatch(new countryActions.LoadAllCountries());
                    this.store.dispatch(new countryActions.LoadCountriesByPage(this.MODAL_DATA));
                    this.store.dispatch(new countryActions.Messages(this.CREATE_COUNTRY_SUCCESS_MESSAGE))
                    return new countryActions.CreateCountrySuccess(country);
                }),
                catchError((error) => of((new countryActions.CreateCountryFail(error.error))))

            )
        )
    );

    @Effect()
    updateCountry$: Observable<Action> = this.actions$.pipe(
        ofType(countryActions.CountryActionTypes.UpdateCountry),
        map((action: countryActions.UpdateCountry) => action.payload),
        mergeMap((country: Country) =>
            this.countryService.updateCountry(country).pipe(
                map(updatedCountry => {
                    // this.router.navigate(['/']);
                    this.store.dispatch(new countryActions.LoadAllCountries());
                    this.store.dispatch(new countryActions.LoadCountriesByPage(this.MODAL_DATA));
                    this.store.dispatch(new countryActions.Messages(this.UPDATE_COUNTRY_SUCCESS_MESSAGE))
                    return new countryActions.UpdateCountrySuccess(updatedCountry);
                }),
                catchError((error) => of((new countryActions.CreateCountryFail(error.error)))
                )
            )));
}
