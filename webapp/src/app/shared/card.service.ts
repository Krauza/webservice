import { Injectable } from '@angular/core';
import { Apollo } from "apollo-angular";
import { Observable } from "rxjs";
import 'rxjs/add/operator/map';

import gql from 'graphql-tag';

@Injectable()
export class CardService {

  constructor(private apollo: Apollo) { }

  createBox(boxId: string, obverse: string, reverse: string): Observable<any> {
    const createCardQuery = gql`
      mutation createCard($boxId: String!, $obverse: String!, $reverse: String!) {
        createCard(box_id: $boxId, obverse: $obverse, reverse: $reverse) {
          card {
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
      mutation: createCardQuery,
      variables: {
        boxId: boxId,
        obverse: obverse,
        reverse: reverse
      }
    });
  }
}
