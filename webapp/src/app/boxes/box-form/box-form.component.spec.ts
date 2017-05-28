import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BoxFormComponent } from './box-form.component';

describe('BoxFormComponent', () => {
  let component: BoxFormComponent;
  let fixture: ComponentFixture<BoxFormComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BoxFormComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BoxFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
