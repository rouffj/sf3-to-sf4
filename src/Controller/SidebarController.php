<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    /**
     * todo Cache(smaxage=3600)
     */
    public function lastGames()
    {
        return $this->render('sidebar/last_games.html.twig', [
            'last_games' => [],
        ]);
    }

    /**
     * todo Cache(smaxage=3600)
     */
    public function lastPlayers()
    {
        return $this->render('sidebar/last_players.html.twig', [
            'last_players' => [],
        ]);
    }
}
