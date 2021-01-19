import { Action } from '@ngrx/store';
import { City } from './city.model';

export enum CityActionTypes {
    LoadAllCities = '[City] Load All Cities',
    LoadAllCitiesSuccess = '[City] Load All Cities Success',
    LoadAllCitiesFail = '[City] Load All Cities Fail',
    LoadCitiesByPage = '[City] Load Cities By Page',
    LoadCitiesByPageSuccess = '[City] Load Cities By Page Success',
    LoadCitiesByPageFail = '[City] Load Cities By Page Fail',
    Messages = '[City] Message',
    CreateCity = '[City] Create',
    CreateCitySuccess = '[City] Create Success',
    CreateCityFail = '[City] Create Fail',
    DeleteCity = '[City] Delete',
    DeleteCitySuccess = '[City] Delete Success',
    DeleteCityFail = '[City] Delete Fail',
    UpdateCity = '[City] Update',
    UpdateCitySuccess = '[City] Update Success',
    UpdateCityFail = '[City] Update Fail'
}

export class LoadAllCities implements Action {
    readonly type = CityActionTypes.LoadAllCities;
}

export class LoadAllCitiesSuccess implements Action {
    readonly type = CityActionTypes.LoadAllCitiesSuccess;

    constructor(public payload: any) {}
}

export class LoadAllCitiesFail implements Action {
    readonly type = CityActionTypes.LoadAllCitiesFail;

    constructor(public payload: any) {}
}

export class LoadCitiesByPage implements Action {
    readonly type = CityActionTypes.LoadCitiesByPage;
    constructor(public payload: any) {}
}

export class LoadCitiesByPageSuccess implements Action {
    readonly type = CityActionTypes.LoadCitiesByPageSuccess;
    constructor(public payload: any) {}
}

export class LoadCitiesByPageFail implements Action {
    readonly type = CityActionTypes.LoadCitiesByPageFail;
    constructor(public payload: any) {}
}

export class Messages implements Action {
    readonly type = CityActionTypes.Messages;

    constructor(public payload: any) {}
}

export class CreateCity implements Action {
    readonly type = CityActionTypes.CreateCity;

    constructor(public payload: any) {}
}

export class CreateCitySuccess implements Action {
    readonly type = CityActionTypes.CreateCitySuccess;

    constructor(public payload: City) {}
}



export class CreateCityFail implements Action {
    readonly type = CityActionTypes.CreateCityFail;

    constructor(public payload: City) {}
}

export class UpdateCity implements Action {
    readonly type = CityActionTypes.UpdateCity;
    constructor(public payload: any) {}
}

export class UpdateCitySuccess implements Action {
    readonly type = CityActionTypes.UpdateCitySuccess;

    constructor(public payload: City) {}
}

export class UpdateCityFail implements Action {
    readonly type = CityActionTypes.UpdateCityFail;

    constructor(public payload: City) {}
}

export class DeleteCity implements Action {
    readonly type = CityActionTypes.DeleteCity;
    constructor(public payload: any) {}
}

export class DeleteCitySuccess implements Action {
    readonly type = CityActionTypes.DeleteCitySuccess;

    constructor(public payload: any) {}
}

export class DeleteCityFail implements Action {
    readonly type = CityActionTypes.DeleteCityFail;

    constructor(public payload: any) {}
}

export type CityActions =
      LoadAllCities
    | LoadAllCitiesSuccess
    | LoadAllCitiesFail
    | LoadCitiesByPage
    | LoadCitiesByPageSuccess
    | LoadCitiesByPageFail
    | Messages
    | CreateCity
    | CreateCitySuccess
    | CreateCityFail
    | DeleteCity
    | DeleteCitySuccess
    | DeleteCityFail
    | UpdateCity
    | UpdateCitySuccess
    | UpdateCityFail
    ;
