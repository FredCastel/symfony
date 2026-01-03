<?php

namespace Core\Infrastructure\Symfony\Controller;

use Banking\Domain\Repository\BankRepository;
use Cluster\Domain\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/app', name: 'app')]
    public function app(): Response
    {
        return $this->render('app.html.twig');
    }
    #[Route('/img/{model}/{id}', name: 'img')]
    public function img(
        string $model,
        string $id,
        // BankRepository $bankRepository,
        // PartyRepository $partyRepository
    ): Response {
        switch ($model) {
            // case 'bank':
            //     $entity = $bankRepository->get($id);
            //     break;
            // case 'party':
            //     $entity = $partyRepository->get($id);
            //     break;

            default:
                return new Response(status: Response::HTTP_NOT_IMPLEMENTED);
        }

        return new Response(
            content: $entity->getImage()->value,
            status: Response::HTTP_OK,
            headers: ['content-type' => 'image/svg+xml']
        );
    }

}