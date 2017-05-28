import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
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

const appRoutes: Routes = [
  { path: '', component: HomePageComponent },
  { path: 'boxes', component: BoxesComponent },
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
    BoxFormComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    RouterModule.forRoot(appRoutes),
    ApolloModule.forRoot(provideClient)
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
