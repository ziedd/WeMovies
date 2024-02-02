<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $request = $client->request('GET', '/api/genres/list');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function testGetMovie()
    {
        $client = static::createClient();
        $request = $client->request('GET', '/api/movies/1'); // Replace 1 with a valid movie ID

        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testSearchMovie()
    {
        $client = static::createClient();
        $request = $client->request('GET', '/api/movies/search', [
            'search' => 'test',
            'genreIds' => '1,2,3',
            'page' => '1',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }
}
