<?php

namespace App\Controller;

use App\Controller\Trait\PaginatingControllerMethodsTrait;
use App\Repository\WorkspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/workspace')]
final class WorkspaceController extends AbstractController
{
    use PaginatingControllerMethodsTrait;

    #[Route('', name: 'app_workspace_index', methods: ['GET'])]
    public function index(Request $request, WorkspaceRepository $repository): JsonResponse
    {
        $workspaces = $repository->findForList($this->getPagination($request));
    }
}
