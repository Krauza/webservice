import {Component, OnInit, EventEmitter, Output} from '@angular/core';
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
import {Box} from "../../models/box";
import {Router} from "@angular/router";
import {BoxService} from "../../shared/box.service";

@Component({
  selector: 'app-box-create',
  templateUrl: './box-create.component.html',
  styleUrls: ['./box-create.component.scss']
})
export class BoxCreateComponent implements OnInit {
  constructor(private boxService: BoxService, private router: Router) {
  }

  ngOnInit() {
  }

}
