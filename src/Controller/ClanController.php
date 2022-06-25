<?php

namespace App\Controller;

use App\Entity\Clan;
use App\Form\ClanType;
use App\Repository\ClanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/clan")
 */
class ClanController extends AbstractController
{
    /**
     * @Route("/", name="app_clan_index", methods={"GET"})
     */
    public function index(ClanRepository $clanRepository): Response
    {
        return $this->render('clan/index.html.twig', [
            'clans' => $clanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_clan_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ClanRepository $clanRepository): Response
    {
        $clan = new Clan();
        $form = $this->createForm(ClanType::class, $clan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clanRepository->add($clan, true);

            return $this->redirectToRoute('app_clan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clan/new.html.twig', [
            'clan' => $clan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_clan_show", methods={"GET"})
     */
    public function show(Clan $clan): Response
    {
        return $this->render('clan/show.html.twig', [
            'clan' => $clan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_clan_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Clan $clan, ClanRepository $clanRepository): Response
    {
        $form = $this->createForm(ClanType::class, $clan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clanRepository->add($clan, true);

            return $this->redirectToRoute('app_clan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clan/edit.html.twig', [
            'clan' => $clan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_clan_delete", methods={"POST"})
     */
    public function delete(Request $request, Clan $clan, ClanRepository $clanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clan->getId(), $request->request->get('_token'))) {
            $clanRepository->remove($clan, true);
        }

        return $this->redirectToRoute('app_clan_index', [], Response::HTTP_SEE_OTHER);
    }
}
