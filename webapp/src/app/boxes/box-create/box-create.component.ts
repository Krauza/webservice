import {Component, OnInit} from '@angular/core';
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

  handleSave(box: Box) {
    this.boxService.createBox(box.name).subscribe(() => {
      this.router.navigate(['/boxes']);
    });
  }
}
