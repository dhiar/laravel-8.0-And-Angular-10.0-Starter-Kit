import { Action } from '@ngrx/store';
import { Country } from './country.model';

export enum CountryActionTypes {
    LoadAllCountries = '[Country] Load All Countries',
    LoadAllCountriesSuccess = '[Country] Load All Countries Success',
    LoadAllCountriesFail = '[Country] Load All Countries Fail',
    LoadCountriesByPage = '[Country] Load Countries By Page',
    LoadCountriesByPageSuccess = '[Country] Load Countries By Page Success',
    LoadCountriesByPageFail = '[Country] Load Countries By Page Fail',
    Messages = '[Country] Message',
    CreateCountry = '[Country] Create',
    CreateCountrySuccess = '[Country] Create Success',
    CreateCountryFail = '[Country] Create Fail',
    DeleteCountry = '[Country] Delete',
    DeleteCountrySuccess = '[Country] Delete Success',
    DeleteCountryFail = '[Country] Delete Fail',
    UpdateCountry = '[Country] Update',
    UpdateCountrySuccess = '[Country] Update Success',
    UpdateCountryFail = '[Country] Update Fail'
}

export class LoadAllCountries implements Action {
    readonly type = CountryActionTypes.LoadAllCountries;
}

export class LoadAllCountriesSuccess implements Action {
    readonly type = CountryActionTypes.LoadAllCountriesSuccess;

    constructor(public payload: any) {}
}

export class LoadAllCountriesFail implements Action {
    readonly type = CountryActionTypes.LoadAllCountriesFail;

    constructor(public payload: any) {}
}

export class LoadCountriesByPage implements Action {
    readonly type = CountryActionTypes.LoadCountriesByPage;
    constructor(public payload: any) {}
}

export class LoadCountriesByPageSuccess implements Action {
    readonly type = CountryActionTypes.LoadCountriesByPageSuccess;
    constructor(public payload: any) {}
}

export class LoadCountriesByPageFail implements Action {
    readonly type = CountryActionTypes.LoadCountriesByPageFail;
    constructor(public payload: any) {}
}

export class Messages implements Action {
    readonly type = CountryActionTypes.Messages;

    constructor(public payload: any) {}
}

export class CreateCountry implements Action {
    readonly type = CountryActionTypes.CreateCountry;

    constructor(public payload: any) {}
}

export class CreateCountrySuccess implements Action {
    readonly type = CountryActionTypes.CreateCountrySuccess;

    constructor(public payload: Country) {}
}



export class CreateCountryFail implements Action {
    readonly type = CountryActionTypes.CreateCountryFail;

    constructor(public payload: Country) {}
}

export class UpdateCountry implements Action {
    readonly type = CountryActionTypes.UpdateCountry;
    constructor(public payload: any) {}
}

export class UpdateCountrySuccess implements Action {
    readonly type = CountryActionTypes.UpdateCountrySuccess;

    constructor(public payload: Country) {}
}

export class UpdateCountryFail implements Action {
    readonly type = CountryActionTypes.UpdateCountryFail;

    constructor(public payload: Country) {}
}

export class DeleteCountry implements Action {
    readonly type = CountryActionTypes.DeleteCountry;
    constructor(public payload: any) {}
}

export class DeleteCountrySuccess implements Action {
    readonly type = CountryActionTypes.DeleteCountrySuccess;

    constructor(public payload: any) {}
}

export class DeleteCountryFail implements Action {
    readonly type = CountryActionTypes.DeleteCountryFail;

    constructor(public payload: any) {}
}

export type CountryActions =
      LoadAllCountries
    | LoadAllCountriesSuccess
    | LoadAllCountriesFail
    | LoadCountriesByPage
    | LoadCountriesByPageSuccess
    | LoadCountriesByPageFail
    | Messages
    | CreateCountry
    | CreateCountrySuccess
    | CreateCountryFail
    | DeleteCountry
    | DeleteCountrySuccess
    | DeleteCountryFail
    | UpdateCountry
    | UpdateCountrySuccess
    | UpdateCountryFail
    ;
