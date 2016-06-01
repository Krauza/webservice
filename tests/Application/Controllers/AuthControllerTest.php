<?php

declare(strict_types=1);
require('ControllerTestCase.php');

class AuthControllerTest extends ControllerTestCase
{
    /**
     * @test
     */
    public function simpleTest()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('#header'));
    }
}
