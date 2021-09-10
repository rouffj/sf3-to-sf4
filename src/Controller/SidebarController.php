<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SidebarController extends AbstractController
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
