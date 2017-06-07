import { Component, OnInit } from '@angular/core';
import { Card } from "../../models/card";
import { CardService } from "../../shared/card.service";
import { Params, ActivatedRoute } from "@angular/router";

@Component({
  selector: 'app-card-create',
  templateUrl: './card-create.component.html',
  styleUrls: ['./card-create.component.scss']
})

export class CardCreateComponent implements OnInit {
  private boxId: string;

  constructor(private cardService: CardService, private route: ActivatedRoute) {}

  ngOnInit() {
    this.route.params.subscribe((params: Params) => {
      this.boxId = params['id'];
    });
  }

  handleSave(card: Card) {
    console.log('aaa', this.boxId);
    this.cardService.createBox(this.boxId, card.obverse, card.reverse).subscribe(({result}) => {
      console.log(result);
    });
  }
}
