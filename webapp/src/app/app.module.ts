import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { RouterModule, Routes } from '@angular/router';
import { ApolloClient, createNetworkInterface } from 'apollo-client';
import { ApolloModule } from 'apollo-angular';

import { AppComponent } from './app.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { NavigationComponent } from './header/navigation/navigation.component';
import { BoxesComponent } from './boxes/boxes.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { HomePageComponent } from './home-page/home-page.component';
import { BoxesListComponent } from './boxes/boxes-list/boxes-list.component';
import { BoxCreateComponent } from './boxes/box-create/box-create.component';
import { BoxFormComponent } from './boxes/box-form/box-form.component';
import { BoxService } from "./shared/box.service";
import { CardFormComponent } from './cards/card-form/card-form.component';
import { CardCreateComponent } from './cards/card-create/card-create.component';

const appRoutes: Routes = [
  { path: '', component: HomePageComponent },
  { path: 'boxes', component: BoxesComponent },
  { path: 'createBox', component: BoxCreateComponent },
  { path: '**', component: PageNotFoundComponent }
];

const client = new ApolloClient({
  networkInterface: createNetworkInterface({
    uri: 'http://localhost:8000'
  })
});

export function provideClient() : ApolloClient {
  return client;
}

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    NavigationComponent,
    BoxesComponent,
    PageNotFoundComponent,
    HomePageComponent,
    BoxesListComponent,
    BoxCreateComponent,
    BoxFormComponent,
    CardFormComponent,
    CardCreateComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    RouterModule.forRoot(appRoutes),
    ApolloModule.forRoot(provideClient)
  ],
  providers: [BoxService],
  bootstrap: [AppComponent]
})
export class AppModule { }
