import { Action } from '@ngrx/store';
import { Zone } from './zone.model';

export enum ZoneActionTypes {
    LoadAllZones = '[Zone] Load All Zones',
    LoadAllZonesSuccess = '[Zone] Load All Zones Success',
    LoadAllZonesFail = '[Zone] Load All Zones Fail',
    LoadZonesByPage = '[Zone] Load Zones By Page',
    LoadZonesByPageSuccess = '[Zone] Load Zones By Page Success',
    LoadZonesByPageFail = '[Zone] Load Zones By Page Fail',
    Messages = '[Zone] Message',
    CreateZone = '[Zone] Create',
    CreateZoneSuccess = '[Zone] Create Success',
    CreateZoneFail = '[Zone] Create Fail',
    DeleteZone = '[Zone] Delete',
    DeleteZoneSuccess = '[Zone] Delete Success',
    DeleteZoneFail = '[Zone] Delete Fail',
    UpdateZone = '[Zone] Update',
    UpdateZoneSuccess = '[Zone] Update Success',
    UpdateZoneFail = '[Zone] Update Fail'
}

export class LoadAllZones implements Action {
    readonly type = ZoneActionTypes.LoadAllZones;
}

export class LoadAllZonesSuccess implements Action {
    readonly type = ZoneActionTypes.LoadAllZonesSuccess;

    constructor(public payload: any) {}
}

export class LoadAllZonesFail implements Action {
    readonly type = ZoneActionTypes.LoadAllZonesFail;

    constructor(public payload: any) {}
}

export class LoadZonesByPage implements Action {
    readonly type = ZoneActionTypes.LoadZonesByPage;
    constructor(public payload: any) {}
}

export class LoadZonesByPageSuccess implements Action {
    readonly type = ZoneActionTypes.LoadZonesByPageSuccess;
    constructor(public payload: any) {}
}

export class LoadZonesByPageFail implements Action {
    readonly type = ZoneActionTypes.LoadZonesByPageFail;
    constructor(public payload: any) {}
}

export class Messages implements Action {
    readonly type = ZoneActionTypes.Messages;

    constructor(public payload: any) {}
}

export class CreateZone implements Action {
    readonly type = ZoneActionTypes.CreateZone;

    constructor(public payload: any) {}
}

export class CreateZoneSuccess implements Action {
    readonly type = ZoneActionTypes.CreateZoneSuccess;

    constructor(public payload: Zone) {}
}



export class CreateZoneFail implements Action {
    readonly type = ZoneActionTypes.CreateZoneFail;

    constructor(public payload: Zone) {}
}

export class UpdateZone implements Action {
    readonly type = ZoneActionTypes.UpdateZone;
    constructor(public payload: any) {}
}

export class UpdateZoneSuccess implements Action {
    readonly type = ZoneActionTypes.UpdateZoneSuccess;

    constructor(public payload: Zone) {}
}

export class UpdateZoneFail implements Action {
    readonly type = ZoneActionTypes.UpdateZoneFail;

    constructor(public payload: Zone) {}
}

export class DeleteZone implements Action {
    readonly type = ZoneActionTypes.DeleteZone;
    constructor(public payload: any) {}
}

export class DeleteZoneSuccess implements Action {
    readonly type = ZoneActionTypes.DeleteZoneSuccess;

    constructor(public payload: any) {}
}

export class DeleteZoneFail implements Action {
    readonly type = ZoneActionTypes.DeleteZoneFail;

    constructor(public payload: any) {}
}

export type ZoneActions =
      LoadAllZones
    | LoadAllZonesSuccess
    | LoadAllZonesFail
    | LoadZonesByPage
    | LoadZonesByPageSuccess
    | LoadZonesByPageFail
    | Messages
    | CreateZone
    | CreateZoneSuccess
    | CreateZoneFail
    | DeleteZone
    | DeleteZoneSuccess
    | DeleteZoneFail
    | UpdateZone
    | UpdateZoneSuccess
    | UpdateZoneFail
    ;
