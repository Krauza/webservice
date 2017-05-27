import { Component, OnInit } from '@angular/core';
import { Apollo } from 'apollo-angular';
import gql from 'graphql-tag';

const getBoxes = gql`
  query getBoxes {
    boxes {
      id,
      name
    }
  }
`;

interface BoxesReponse {
  boxes
}

@Component({
  selector: 'app-boxes-list',
  templateUrl: './boxes-list.component.html',
  styleUrls: ['./boxes-list.component.scss']
})
export class BoxesListComponent implements OnInit {
  private boxes = [];

  constructor(private apollo: Apollo) { }

  ngOnInit() {
    this.apollo.watchQuery<BoxesReponse>({
      query: getBoxes
    }).subscribe(({data}) => {
      this.boxes = data.boxes;
    });
  }
}
