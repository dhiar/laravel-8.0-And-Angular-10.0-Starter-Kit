import { Zone } from './zone.model';
import { ZoneActions, ZoneActionTypes } from './zone.actions';
import { createSelector, createFeatureSelector } from '@ngrx/store';
import * as fromRoot from '../index';

export interface State extends fromRoot.State {
    zones: ZoneState;
}

export interface ZoneState {
    zones: [];
    newZone: Zone;
    zoneToUpdate: Zone;
    deletedZoneId: number;
    error: any;
    message: any;
    zonesByPage: any;

}

export const initialState: ZoneState = {
    zones: [],
    newZone: {
        id: null,
        name: null,
        code: null,
        status: null,
        zone_flag: null
    },
    zoneToUpdate: {
        id: null,
        name: null,
        code: null,
        status: null,
        zone_flag: null
    },
    deletedZoneId: null,
    error: '',
    message: '',
    zonesByPage: ''



};

const getZoneFeatureState = createFeatureSelector<ZoneState>('zones');

export const getAllZones = createSelector(
    getZoneFeatureState,
    state => state.zones
);

export const getZonesByPage = createSelector(
    getZoneFeatureState,
    state => state.zonesByPage
);

export const getError = createSelector(
    getZoneFeatureState,
    state => state.error
);

export const getMessage = createSelector(
    getZoneFeatureState,
    state => state.message
);
export function reducer(state: ZoneState = initialState, action: ZoneActions): ZoneState {
    switch (action.type) {
        case ZoneActionTypes.LoadAllZonesSuccess:
            return {
                ...state,
                zones: action.payload,
                error: ''
            };
        case ZoneActionTypes.LoadAllZonesFail:
            return {
                ...state,
                zones: [],
                error: action.payload
            };
        case ZoneActionTypes.LoadZonesByPageSuccess:
            return {
                ...state,
                zonesByPage: action.payload,
                error: ''
            };
        case ZoneActionTypes.LoadZonesByPageFail:
            return {
                ...state,
                zonesByPage: [],
                error: action.payload
            };

        case ZoneActionTypes.CreateZoneSuccess:
            return {
                ...state,
                newZone: action.payload,
                error: ''
            };
        case ZoneActionTypes.CreateZoneFail:
            return {
                ...state,
                newZone: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  zone_flag: null
                },
                error: action.payload,
                message: ''
            };
        case ZoneActionTypes.Messages:
            return {
                ...state,
                message: action.payload
            };
        case ZoneActionTypes.DeleteZoneSuccess:
            return {
                ...state,
                deletedZoneId: action.payload,
                error: '',
                message: ''
            };
        case ZoneActionTypes.DeleteZoneFail:
            return {
                ...state,
                deletedZoneId: null,
                error: action.payload,
                message: ''
            };
        case ZoneActionTypes.UpdateZoneSuccess:
            return {
                ...state,
                zoneToUpdate: action.payload,
                error: '',
                message: ''
            };
        case ZoneActionTypes.UpdateZoneFail:
            return {
                ...state,
                zoneToUpdate: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  zone_flag: null
                },
                error: action.payload,
                message: ''
            };
        default:
            return state;
    }
}
