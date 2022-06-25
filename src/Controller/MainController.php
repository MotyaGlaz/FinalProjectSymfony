<?php

namespace App\Controller;

use App\Entity\Clan;
use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function show(): Response
    {
        $request = Request::createFromGlobals();
        $clan = $request->query->get('clan');
        if ($clan != '') {
            $clans = $this->getDoctrine()->getRepository(Clan::class)->findBy(array('id' => $clan));
            $players = $this->getDoctrine()->getRepository(Player::class)->findBy(array('clan' => $clan));
            $clanName = $clans[0]->getName();
            $games = [];
            foreach ($players as $player) {
                $playerGames = $player->getGames();
                foreach ($playerGames as $game) {
                    $games[] = $game->getName();
                }
            }
            $games = array_unique($games);
            return $this->render('main/result.html.twig', [
                'games' => $games,
                'clan_name' => $clanName,
            ]);
        } else {
            $clans = $this->getDoctrine()->getRepository(Clan::class)->findAll();
            return $this->render('main/index.html.twig', [
                'clans' => $clans,
            ]);
        }
    }

}
