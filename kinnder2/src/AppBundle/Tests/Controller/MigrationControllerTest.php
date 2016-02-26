<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MigrationControllerTest extends WebTestCase
{
    public function testMigrateactivity()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/activity/{id}');
    }

}
