<?php

namespace App\Controller\Trait;

use App\Model\Pagination;
use Symfony\Component\HttpFoundation\Request;

use function dump;

trait PaginatingControllerMethodsTrait
{
    public function getPagination(
        Request $request,
        string $prefix = 'pagination-',
        ?int $maxPage = null,
        array $limits = [10, 20, 50, 100],
        int $defaultLimit = 10,
        int $defaultPage = 1,
    ): Pagination {
        $query = $request->query->all();
        $page = (int)($query[$prefix . 'page'] ?? $defaultPage);
        $limit = (int)($query[$prefix . 'limit'] ?? $defaultLimit);
        $limit = in_array($limit, $limits, true) ? $limit : $defaultLimit;
        $page = max($page, 1);
        $page = $maxPage !== null ? min($page, $maxPage) : $page;
        return new Pagination($page, $limit);
    }
}
