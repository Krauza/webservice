<?php

declare(strict_types=1);
require('ControllerTestCase.php');

class AuthControllerTest extends ControllerTestCase
{
    /**
     * @test
     */
    public function shouldDisplayLoginForm()
    {
        // When
        $crawler = $this->client->request('GET', '/auth/login');

        // Then
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('#login-form'));
    }

    public function shouldLoginToPage()
    {
        // When
        $crawler = $this->loginToPage();

        // Then
        $this->assertCount(1, $crawler->filter('#subjects'));

        // When user logged
        $crawler = $this->client->request('GET', '/auth/login');

        // Then redirect to subjects page
        $this->assertCount(1, $crawler->filter('#subjects'));
    }

    /**
     * @test
     */
    public function shouldDisplayAlertForWrongCredentials()
    {
        // When
        $crawler = $this->loginToPage('wrong-email@test.test');

        // Then
        $this->assertCount(1, $crawler->filter('#login-form'));
    }

    /**
     * @test
     */
    public function shouldLogout()
    {
        // Given
        $this->loginToPage();

        // When
        $crawler = $this->client->request('GET', '/auth/logout');

        // Then
        $this->assertCount(1, $crawler->filter('#login-form'));
    }
}
