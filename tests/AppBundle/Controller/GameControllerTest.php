<?php

namespace Tests\AppBundle\Controller;

use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameControllerTest extends WebTestCase
{
    public function testReset()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/en/game');

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $reset = $crawler->selectLink('Reset the game');

        self::assertCount(1, $reset, 'Reset link should be displayed');

        $client->click($reset->link());

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('/en/game', $response->headers->get('location'));
    }

    public function testPlayLetter()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/en/game');

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $playLetterA = $crawler->selectLink('A');

        self::assertCount(1, $playLetterA, 'Letter "A" link should be displayed');

        $client->click($playLetterA->link());

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('/en/game', $response->headers->get('location'));

        $crawler = $client->followRedirect();

        $remainingAttempts = $crawler->filter('#remaining-attempts');

        self::assertCount(1, $remainingAttempts, 'Remaining attempts should be displayed');
        self::assertContains((string) (Game::MAX_ATTEMPTS - 1), $remainingAttempts->text(), 'An attempt should have been lost');
        self::assertCount(8, $crawler->filter('.letter.hidden'), 'All letters should be hidden');
    }

    public function testPlayLetterFound()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/en/game');

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $playLetterT = $crawler->selectLink('T');

        self::assertCount(1, $playLetterT, 'Letter "T" link should be displayed');

        $client->click($playLetterT->link());

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('/en/game', $response->headers->get('location'));

        $crawler = $client->followRedirect();

        $remainingAttempts = $crawler->filter('#remaining-attempts');

        self::assertCount(1, $remainingAttempts, 'Remaining attempts should be displayed');
        self::assertContains((string) Game::MAX_ATTEMPTS, $remainingAttempts->text(), 'An attempt should have been lost');
        self::assertCount(6, $crawler->filter('.letter.hidden'), 'All letters but "T" should be hidden');
    }

    public function testPlayWordFails()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/en/game');

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $playWord = $crawler->selectButton('Let me guess...');

        self::assertCount(1, $playWord, 'Word form should be displayed');

        $client->submit($playWord->form(['word' => 'wrong']));

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('/en/game/failed', $response->headers->get('location'));

        $crawler = $client->followRedirect();

        $result = $crawler->filter('#result');

        self::assertCount(1, $result, 'Result should be displayed');
        self::assertContains("testword", $result->text(), 'Result text should match');
    }

    public function testPlayWordWins()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/en/game');

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $playWord = $crawler->selectButton('Let me guess...');

        self::assertCount(1, $playWord, 'Word form should be displayed');

        $client->submit($playWord->form(['word' => 'testword']));

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('/en/game/won', $response->headers->get('location'));

        $crawler = $client->followRedirect();

        $result = $crawler->filter('#result');

        self::assertCount(1, $result, 'Result should be displayed');
        self::assertContains("testword", $result->text(), 'Result text should match');
    }
}
