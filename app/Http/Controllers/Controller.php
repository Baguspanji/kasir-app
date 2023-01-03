<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function paginate($items, $limit = 10)
    {
        $itemsPaginated = $items->paginate($limit);

        $resource = $itemsPaginated
            ->getCollection()
            ->map(function ($item) {
                // $item->data = null;
                return $item;
            })->toArray();

        $itemPagination = [
            'total' => $itemsPaginated->total(),
            'per_page' => $itemsPaginated->perPage(),
            'current_page' => $itemsPaginated->currentPage(),
        ];

        return [
            'data' => $resource,
            'pagination' => $itemPagination,
        ];
    }

    public static function customPaginate(array $items, $perPage = 10, $page = 1, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $paginated = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $modified = [];
        foreach ($paginated->items() as $key) {
            array_push($modified, $key);
        }

        $itemPagination = [
            'total' => $paginated->total(),
            'per_page' => $paginated->perPage(),
            'current_page' => $paginated->currentPage(),
        ];

        return [
            'data' => $modified,
            'pagination' => $itemPagination,
        ];
    }
}
