import { Country } from './country.model';
import { CountryActions, CountryActionTypes } from './country.actions';
import { createSelector, createFeatureSelector } from '@ngrx/store';
import * as fromRoot from '../index';

export interface State extends fromRoot.State {
    countries: CountryState;
}

export interface CountryState {
    countries: [];
    newCountry: Country;
    countryToUpdate: Country;
    deletedCountryId: number;
    error: any;
    message: any;
    countriesByPage: any;

}

export const initialState: CountryState = {
    countries: [],
    newCountry: {
        id: null,
        name: null,
        code: null,
        status: null,
        country_flag: null
    },
    countryToUpdate: {
        id: null,
        name: null,
        code: null,
        status: null,
        country_flag: null
    },
    deletedCountryId: null,
    error: '',
    message: '',
    countriesByPage: ''



};

const getCountryFeatureState = createFeatureSelector<CountryState>('countries');

export const getAllCountries = createSelector(
    getCountryFeatureState,
    state => state.countries
);

export const getCountriesByPage = createSelector(
    getCountryFeatureState,
    state => state.countriesByPage
);

export const getError = createSelector(
    getCountryFeatureState,
    state => state.error
);

export const getMessage = createSelector(
    getCountryFeatureState,
    state => state.message
);
export function reducer(state: CountryState = initialState, action: CountryActions): CountryState {
    switch (action.type) {
        case CountryActionTypes.LoadAllCountriesSuccess:
            return {
                ...state,
                countries: action.payload,
                error: ''
            };
        case CountryActionTypes.LoadAllCountriesFail:
            return {
                ...state,
                countries: [],
                error: action.payload
            };
        case CountryActionTypes.LoadCountriesByPageSuccess:
            return {
                ...state,
                countriesByPage: action.payload,
                error: ''
            };
        case CountryActionTypes.LoadCountriesByPageFail:
            return {
                ...state,
                countriesByPage: [],
                error: action.payload
            };

        case CountryActionTypes.CreateCountrySuccess:
            return {
                ...state,
                newCountry: action.payload,
                error: ''
            };
        case CountryActionTypes.CreateCountryFail:
            return {
                ...state,
                newCountry: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  country_flag: null
                },
                error: action.payload,
                message: ''
            };
        case CountryActionTypes.Messages:
            return {
                ...state,
                message: action.payload
            };
        case CountryActionTypes.DeleteCountrySuccess:
            return {
                ...state,
                deletedCountryId: action.payload,
                error: '',
                message: ''
            };
        case CountryActionTypes.DeleteCountryFail:
            return {
                ...state,
                deletedCountryId: null,
                error: action.payload,
                message: ''
            };
        case CountryActionTypes.UpdateCountrySuccess:
            return {
                ...state,
                countryToUpdate: action.payload,
                error: '',
                message: ''
            };
        case CountryActionTypes.UpdateCountryFail:
            return {
                ...state,
                countryToUpdate: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  country_flag: null
                },
                error: action.payload,
                message: ''
            };
        default:
            return state;
    }
}
