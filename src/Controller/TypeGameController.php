<?php

namespace App\Controller;

use App\Entity\TypeGame;
use App\Form\TypeGameType;
use App\Repository\TypeGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/game")
 */
class TypeGameController extends AbstractController
{
    /**
     * @Route("/", name="app_type_game_index", methods={"GET"})
     */
    public function index(TypeGameRepository $typeGameRepository): Response
    {
        return $this->render('type_game/index.html.twig', [
            'type_games' => $typeGameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_game_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeGameRepository $typeGameRepository): Response
    {
        $typeGame = new TypeGame();
        $form = $this->createForm(TypeGameType::class, $typeGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeGameRepository->add($typeGame, true);

            return $this->redirectToRoute('app_type_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_game/new.html.twig', [
            'type_game' => $typeGame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_game_show", methods={"GET"})
     */
    public function show(TypeGame $typeGame): Response
    {
        return $this->render('type_game/show.html.twig', [
            'type_game' => $typeGame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_game_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeGame $typeGame, TypeGameRepository $typeGameRepository): Response
    {
        $form = $this->createForm(TypeGameType::class, $typeGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeGameRepository->add($typeGame, true);

            return $this->redirectToRoute('app_type_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_game/edit.html.twig', [
            'type_game' => $typeGame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_game_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeGame $typeGame, TypeGameRepository $typeGameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeGame->getId(), $request->request->get('_token'))) {
            $typeGameRepository->remove($typeGame, true);
        }

        return $this->redirectToRoute('app_type_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
