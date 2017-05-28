import { Component, OnInit } from '@angular/core';
import {BoxService} from "../../shared/box.service";

@Component({
  selector: 'app-boxes-list',
  templateUrl: './boxes-list.component.html',
  styleUrls: ['./boxes-list.component.scss']
})
export class BoxesListComponent implements OnInit {
  private boxes = [];

  constructor(private boxService: BoxService) { }

  ngOnInit() {
    this.boxService.getBoxes().subscribe(({data}) => {
      this.boxes = data;
    });
  }
}
