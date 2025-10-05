<?php

namespace App\Controller;

use App\Repository\WorkspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use function dump;

#[Route('/workspace')]
final class WorkspaceController extends AbstractController
{
    #[Route('', name: 'app_workspace_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
    }
}
