import {Component, OnInit, Output, EventEmitter} from '@angular/core';
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
import {Card} from "../../models/card";

@Component({
  selector: 'app-card-form',
  templateUrl: './card-form.component.html',
  styleUrls: ['./card-form.component.scss']
})

export class CardFormComponent implements OnInit {
  form: FormGroup;

  @Output()
  private onSave = new EventEmitter<Card>();

  constructor(private fb: FormBuilder) {
    this.form = this.fb.group({
      obverse: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(512)]],
      reverse: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(512)]]
    });
  }

  ngOnInit() {
  }

  onSubmit(value) {
    this.onSave.emit({
      id: undefined,
      obverse: value.obverse,
      reverse: value.reverse
    });
  }
}
