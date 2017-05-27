import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BoxCreateComponent } from './box-create.component';

describe('BoxCreateComponent', () => {
  let component: BoxCreateComponent;
  let fixture: ComponentFixture<BoxCreateComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BoxCreateComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BoxCreateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
