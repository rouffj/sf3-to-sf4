<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game")
 * todo IsGranted("ROLE_PLAYER")
 */
class GameController extends Controller
{
    /**
     * @Route(name="app_game_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('game/index.html.twig', [
            'game' => $this->get('app.game.runner')->loadGame(),
        ]);
    }

    /**
     * @Route("/reset", name="app_game_reset", methods={"GET"})
     */
    public function reset()
    {
        $this->get('app.game.runner')->resetGame();

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route(
     *     "/play-letter/{letter}",
     *     requirements={"letter": "[A-Z]"},
     *     name="app_game_play_letter",
     *     methods={"GET"}
     * )
     */
    public function playLetter($letter)
    {
        $game = $this->get('app.game.runner')->playLetter($letter);

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        if ($game->isHanged()) {
            return $this->redirectToRoute('app_game_failed');
        }

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route(
     *     "/play-word",
     *     name="app_game_play_word",
     *     methods={"POST"}
     * )
     */
    public function playWord(Request $request)
    {
        $game = $this->get('app.game.runner')->playWord($request->request->getAlpha('word'));

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        return $this->redirectToRoute('app_game_failed');
    }

    /**
     * @Route("/won", name="app_game_won", methods={"GET"})
     */
    public function won()
    {
        return $this->render('game/won.html.twig', [
            'game' => $this->get('app.game.runner')->resetGameOnSuccess(),
        ]);
    }

    /**
     * @Route("/failed", name="app_game_failed", methods={"GET"})
     */
    public function failed()
    {
        return $this->render('game/failed.html.twig', [
            'game' => $this->get('app.game.runner')->resetGameOnFailure(),
        ]);
    }
}
