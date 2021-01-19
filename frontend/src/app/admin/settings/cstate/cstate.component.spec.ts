import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CstateComponent } from './cstate.component';

describe('CstateComponent', () => {
  let component: CstateComponent;
  let fixture: ComponentFixture<CstateComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CstateComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CstateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
