import { City } from './city.model';
import { CityActions, CityActionTypes } from './city.actions';
import { createSelector, createFeatureSelector } from '@ngrx/store';
import * as fromRoot from '../index';

export interface State extends fromRoot.State {
    cities: CityState;
}

export interface CityState {
    cities: [];
    newCity: City;
    cityToUpdate: City;
    deletedCityId: number;
    error: any;
    message: any;
    citiesByPage: any;

}

export const initialState: CityState = {
    cities: [],
    newCity: {
        id: null,
        name: null,
        code: null,
        status: null,
        city_flag: null
    },
    cityToUpdate: {
        id: null,
        name: null,
        code: null,
        status: null,
        city_flag: null
    },
    deletedCityId: null,
    error: '',
    message: '',
    citiesByPage: ''



};

const getCityFeatureState = createFeatureSelector<CityState>('cities');

export const getAllCities = createSelector(
    getCityFeatureState,
    state => state.cities
);

export const getCitiesByPage = createSelector(
    getCityFeatureState,
    state => state.citiesByPage
);

export const getError = createSelector(
    getCityFeatureState,
    state => state.error
);

export const getMessage = createSelector(
    getCityFeatureState,
    state => state.message
);
export function reducer(state: CityState = initialState, action: CityActions): CityState {
    switch (action.type) {
        case CityActionTypes.LoadAllCitiesSuccess:
            return {
                ...state,
                cities: action.payload,
                error: ''
            };
        case CityActionTypes.LoadAllCitiesFail:
            return {
                ...state,
                cities: [],
                error: action.payload
            };
        case CityActionTypes.LoadCitiesByPageSuccess:
            return {
                ...state,
                citiesByPage: action.payload,
                error: ''
            };
        case CityActionTypes.LoadCitiesByPageFail:
            return {
                ...state,
                citiesByPage: [],
                error: action.payload
            };

        case CityActionTypes.CreateCitySuccess:
            return {
                ...state,
                newCity: action.payload,
                error: ''
            };
        case CityActionTypes.CreateCityFail:
            return {
                ...state,
                newCity: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  city_flag: null
                },
                error: action.payload,
                message: ''
            };
        case CityActionTypes.Messages:
            return {
                ...state,
                message: action.payload
            };
        case CityActionTypes.DeleteCitySuccess:
            return {
                ...state,
                deletedCityId: action.payload,
                error: '',
                message: ''
            };
        case CityActionTypes.DeleteCityFail:
            return {
                ...state,
                deletedCityId: null,
                error: action.payload,
                message: ''
            };
        case CityActionTypes.UpdateCitySuccess:
            return {
                ...state,
                cityToUpdate: action.payload,
                error: '',
                message: ''
            };
        case CityActionTypes.UpdateCityFail:
            return {
                ...state,
                cityToUpdate: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  city_flag: null
                },
                error: action.payload,
                message: ''
            };
        default:
            return state;
    }
}
