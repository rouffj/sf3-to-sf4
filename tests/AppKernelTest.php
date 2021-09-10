<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppKernelTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient([], ['HTTP_HOST' => 'hangman']);

        $client->request(Request::METHOD_GET, '/');

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('http://hangman/en/', $response->headers->get('location'));
    }

    /**
     * @dataProvider provideRoutes
     *
     * @param string      $method
     * @param string      $url
     * @param int         $statusCode
     * @param string      $route
     * @param string|null $title
     */
    public function testRouting($method, $url, $statusCode, $route, $title = null)
    {
        $client = static::createClient();

        $client->request($method, $url);

        self::assertSame($route, $client->getRequest()->attributes->get('_route'), 'Route should match');
        self::assertSame($statusCode, $client->getResponse()->getStatusCode(), 'Status code should match');

        if ($title) {
            self::assertSame($title, trim($client->getCrawler()->filter('title')->text()));
        }
    }

    /**
     * @return iterable
     */
    public function provideRoutes()
    {
        yield 'Main index' => [Request::METHOD_GET, '/en/', Response::HTTP_OK, 'app_main_index', 'Hangman | Sign-in'];
        yield 'Main contact' => [Request::METHOD_GET, '/en/contact', Response::HTTP_OK, 'app_main_contact', 'Hangman | Contact us'];

        yield 'Game index' => [Request::METHOD_GET, '/en/game', Response::HTTP_OK, 'app_game_index', 'Hangman | Let\'s play!'];
        yield 'Game reset' => [Request::METHOD_GET, '/en/game/reset', Response::HTTP_NOT_FOUND, 'app_game_reset'];
        yield 'Game play letter' => [Request::METHOD_GET, '/en/game/play-letter/A', Response::HTTP_NOT_FOUND, 'app_game_play_letter'];
        yield 'Game play word' => [Request::METHOD_POST, '/en/game/play-word', Response::HTTP_NOT_FOUND, 'app_game_play_word'];
        yield 'Game won' => [Request::METHOD_GET, '/en/game/won', Response::HTTP_NOT_FOUND, 'app_game_won'];
        yield 'Game failed' => [Request::METHOD_GET, '/en/game/failed', Response::HTTP_NOT_FOUND, 'app_game_failed'];

        yield 'Security login' => [Request::METHOD_POST, '/en/login', Response::HTTP_BAD_REQUEST, 'app_security_login'];
        yield 'Security logout' => [Request::METHOD_GET, '/en/logout', Response::HTTP_FOUND, 'app_security_logout'];
    }
}
