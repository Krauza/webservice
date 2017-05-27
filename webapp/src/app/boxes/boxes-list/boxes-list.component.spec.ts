import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BoxesListComponent } from './boxes-list.component';

describe('BoxesListComponent', () => {
  let component: BoxesListComponent;
  let fixture: ComponentFixture<BoxesListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BoxesListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BoxesListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
