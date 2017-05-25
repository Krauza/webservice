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

@Component({
  selector: 'app-boxes',
  templateUrl: './boxes.component.html',
  styleUrls: ['./boxes.component.scss']
})
export class BoxesComponent implements OnInit {

  constructor(private apollo: Apollo) { }

  ngOnInit() {
    this.apollo.watchQuery({
      query: getBoxes
    }).subscribe(({data}) => {
      console.log(data);
    });
  }

}
