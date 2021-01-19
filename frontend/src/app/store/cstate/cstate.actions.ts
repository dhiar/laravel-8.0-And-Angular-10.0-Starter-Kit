import { Action } from '@ngrx/store';
import { Cstate } from './cstate.model';

export enum CstateActionTypes {
    LoadAllCstates = '[Cstate] Load All Cstates',
    LoadAllCstatesSuccess = '[Cstate] Load All Cstates Success',
    LoadAllCstatesFail = '[Cstate] Load All Cstates Fail',
    LoadCstatesByPage = '[Cstate] Load Cstates By Page',
    LoadCstatesByPageSuccess = '[Cstate] Load Cstates By Page Success',
    LoadCstatesByPageFail = '[Cstate] Load Cstates By Page Fail',
    Messages = '[Cstate] Message',
    CreateCstate = '[Cstate] Create',
    CreateCstateSuccess = '[Cstate] Create Success',
    CreateCstateFail = '[Cstate] Create Fail',
    DeleteCstate = '[Cstate] Delete',
    DeleteCstateSuccess = '[Cstate] Delete Success',
    DeleteCstateFail = '[Cstate] Delete Fail',
    UpdateCstate = '[Cstate] Update',
    UpdateCstateSuccess = '[Cstate] Update Success',
    UpdateCstateFail = '[Cstate] Update Fail'
}

export class LoadAllCstates implements Action {
    readonly type = CstateActionTypes.LoadAllCstates;
}

export class LoadAllCstatesSuccess implements Action {
    readonly type = CstateActionTypes.LoadAllCstatesSuccess;

    constructor(public payload: any) {}
}

export class LoadAllCstatesFail implements Action {
    readonly type = CstateActionTypes.LoadAllCstatesFail;

    constructor(public payload: any) {}
}

export class LoadCstatesByPage implements Action {
    readonly type = CstateActionTypes.LoadCstatesByPage;
    constructor(public payload: any) {}
}

export class LoadCstatesByPageSuccess implements Action {
    readonly type = CstateActionTypes.LoadCstatesByPageSuccess;
    constructor(public payload: any) {}
}

export class LoadCstatesByPageFail implements Action {
    readonly type = CstateActionTypes.LoadCstatesByPageFail;
    constructor(public payload: any) {}
}

export class Messages implements Action {
    readonly type = CstateActionTypes.Messages;

    constructor(public payload: any) {}
}

export class CreateCstate implements Action {
    readonly type = CstateActionTypes.CreateCstate;

    constructor(public payload: any) {}
}

export class CreateCstateSuccess implements Action {
    readonly type = CstateActionTypes.CreateCstateSuccess;

    constructor(public payload: Cstate) {}
}



export class CreateCstateFail implements Action {
    readonly type = CstateActionTypes.CreateCstateFail;

    constructor(public payload: Cstate) {}
}

export class UpdateCstate implements Action {
    readonly type = CstateActionTypes.UpdateCstate;
    constructor(public payload: any) {}
}

export class UpdateCstateSuccess implements Action {
    readonly type = CstateActionTypes.UpdateCstateSuccess;

    constructor(public payload: Cstate) {}
}

export class UpdateCstateFail implements Action {
    readonly type = CstateActionTypes.UpdateCstateFail;

    constructor(public payload: Cstate) {}
}

export class DeleteCstate implements Action {
    readonly type = CstateActionTypes.DeleteCstate;
    constructor(public payload: any) {}
}

export class DeleteCstateSuccess implements Action {
    readonly type = CstateActionTypes.DeleteCstateSuccess;

    constructor(public payload: any) {}
}

export class DeleteCstateFail implements Action {
    readonly type = CstateActionTypes.DeleteCstateFail;

    constructor(public payload: any) {}
}

export type CstateActions =
      LoadAllCstates
    | LoadAllCstatesSuccess
    | LoadAllCstatesFail
    | LoadCstatesByPage
    | LoadCstatesByPageSuccess
    | LoadCstatesByPageFail
    | Messages
    | CreateCstate
    | CreateCstateSuccess
    | CreateCstateFail
    | DeleteCstate
    | DeleteCstateSuccess
    | DeleteCstateFail
    | UpdateCstate
    | UpdateCstateSuccess
    | UpdateCstateFail
    ;
