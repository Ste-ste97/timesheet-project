<?php

namespace App\Models\Traits;


use App\Services\Paginator\Paginator;
use App\Services\Paginator\PaginatorResponse;

trait CustomPagination
{
    public function scopeCustomPagination($query, int $perPage, ?int $maxResult): PaginatorResponse
    {
        return (new Paginator($query))->paginate($perPage, $maxResult);
    }
}
