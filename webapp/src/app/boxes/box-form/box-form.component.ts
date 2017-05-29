import {Component, OnInit, EventEmitter, Output} from '@angular/core';
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
import {Box} from "../../models/box";

@Component({
  selector: 'app-box-form',
  templateUrl: './box-form.component.html',
  styleUrls: ['./box-form.component.scss']
})
export class BoxFormComponent implements OnInit {
  form: FormGroup;

  @Output()
  private onSave = new EventEmitter<Box>();

  constructor(private fb: FormBuilder) {
    this.form = this.fb.group({
      boxName: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(128)]]
    });
  }

  ngOnInit() {
  }

  onSubmit(value) {
    this.onSave.emit({
      id: undefined,
      name: value.boxName
    });
  }
}
