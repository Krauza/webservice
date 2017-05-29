import { Injectable } from '@angular/core';
import { Apollo } from "apollo-angular";
import { Box } from "../models/box";
import gql from 'graphql-tag';

import {Observable} from "rxjs";
import 'rxjs/add/operator/map';

interface BoxesResponse {
  boxes
}

@Injectable()
export class BoxService {

  constructor(private apollo: Apollo) { }

  getBoxes(): Observable<Box[]> {
    const getBoxesQuery = gql`
      query getBoxes {
        boxes {
          id,
          name
        }
      }
    `;

    return this.apollo.watchQuery<BoxesResponse>({ query: getBoxesQuery }).map(({data}) => data.boxes);
  }

  createBox(boxName): Observable<any> {
    const createBoxQuery = gql`
      mutation createBox($boxName: String!) {
        createBox(name: $boxName) {
          box {
            id
          }
          errors {
            errorType
            key
            message
          }
        }
      }
    `;

    return this.apollo.mutate({
      mutation: createBoxQuery,
      variables: {
        boxName: boxName
      }
    });
  }
}
