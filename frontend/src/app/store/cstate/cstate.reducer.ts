import { Cstate } from './cstate.model';
import { CstateActions, CstateActionTypes } from './cstate.actions';
import { createSelector, createFeatureSelector } from '@ngrx/store';
import * as fromRoot from '../index';

export interface State extends fromRoot.State {
    cstates: CstateState;
}

export interface CstateState {
    cstates: [];
    newCstate: Cstate;
    cstateToUpdate: Cstate;
    deletedCstateId: number;
    error: any;
    message: any;
    cstatesByPage: any;

}

export const initialState: CstateState = {
    cstates: [],
    newCstate: {
        id: null,
        name: null,
        code: null,
        status: null,
        cstate_flag: null
    },
    cstateToUpdate: {
        id: null,
        name: null,
        code: null,
        status: null,
        cstate_flag: null
    },
    deletedCstateId: null,
    error: '',
    message: '',
    cstatesByPage: ''



};

const getCstateFeatureState = createFeatureSelector<CstateState>('cstates');

export const getAllCstates = createSelector(
    getCstateFeatureState,
    state => state.cstates
);

export const getCstatesByPage = createSelector(
    getCstateFeatureState,
    state => state.cstatesByPage
);

export const getError = createSelector(
    getCstateFeatureState,
    state => state.error
);

export const getMessage = createSelector(
    getCstateFeatureState,
    state => state.message
);
export function reducer(state: CstateState = initialState, action: CstateActions): CstateState {
    switch (action.type) {
        case CstateActionTypes.LoadAllCstatesSuccess:
            return {
                ...state,
                cstates: action.payload,
                error: ''
            };
        case CstateActionTypes.LoadAllCstatesFail:
            return {
                ...state,
                cstates: [],
                error: action.payload
            };
        case CstateActionTypes.LoadCstatesByPageSuccess:
            return {
                ...state,
                cstatesByPage: action.payload,
                error: ''
            };
        case CstateActionTypes.LoadCstatesByPageFail:
            return {
                ...state,
                cstatesByPage: [],
                error: action.payload
            };

        case CstateActionTypes.CreateCstateSuccess:
            return {
                ...state,
                newCstate: action.payload,
                error: ''
            };
        case CstateActionTypes.CreateCstateFail:
            return {
                ...state,
                newCstate: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  cstate_flag: null
                },
                error: action.payload,
                message: ''
            };
        case CstateActionTypes.Messages:
            return {
                ...state,
                message: action.payload
            };
        case CstateActionTypes.DeleteCstateSuccess:
            return {
                ...state,
                deletedCstateId: action.payload,
                error: '',
                message: ''
            };
        case CstateActionTypes.DeleteCstateFail:
            return {
                ...state,
                deletedCstateId: null,
                error: action.payload,
                message: ''
            };
        case CstateActionTypes.UpdateCstateSuccess:
            return {
                ...state,
                cstateToUpdate: action.payload,
                error: '',
                message: ''
            };
        case CstateActionTypes.UpdateCstateFail:
            return {
                ...state,
                cstateToUpdate: {
                  id: null,
                  name: null,
                  code: null,
                  status: null,
                  cstate_flag: null
                },
                error: action.payload,
                message: ''
            };
        default:
            return state;
    }
}
