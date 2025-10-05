<?php

namespace App\Controller;

use App\Controller\Trait\PaginatingControllerMethodsTrait;
use App\Repository\WorkspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/workspace')]
final class WorkspaceController extends AbstractController
{
    use PaginatingControllerMethodsTrait;

    /**
     * @throws ExceptionInterface
     */
    #[Route('', name: 'app_workspace_index', methods: ['GET'])]
    public function index(
        Request $request,
        WorkspaceRepository $repository,
        SerializerInterface $serializer,
    ): JsonResponse {
        return new JsonResponse(
            data: $serializer->serialize(
                data: $repository->findForList($this->getPagination($request)),
                format: 'json',
                context: [AbstractNormalizer::GROUPS => ['api:workspace:list']],
            ),
            json: true,
        );
    }
}
