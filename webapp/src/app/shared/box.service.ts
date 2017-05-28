import { Injectable } from '@angular/core';
import {Apollo, ApolloQueryObservable} from "apollo-angular";
import {Box} from "../models/box";
import gql from 'graphql-tag';

@Injectable()
export class BoxService {

  constructor(private apollo: Apollo) { }

  getBoxes(): ApolloQueryObservable<Box[]> {
    const getBoxes = gql`
      query getBoxes {
        boxes {
          id,
          name
        }
      }
    `;

    return this.apollo.watchQuery({ query: getBoxes });
  }
}
