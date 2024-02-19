<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Throwable;

trait Paginatable
{
    private const ASC  = 'asc';
    private const DESC = 'desc';

    public function scopeSetUpQuery(Builder $baseQuery): Builder
    {
        $sortOrder = request()->input('sortOrder');
        if ($sortOrder !== self::ASC && $sortOrder !== self::DESC) {
            $sortOrder = null;
        }

        $sortField = request()->input('sortField');

        if ($sortField !== null && $sortOrder !== null) {
            $baseQuery->customSort($sortField, $sortOrder);
        }

        $search = request()->input('search');

        if ($search !== null) {
            $baseQuery->customSearch($search);
        }

        return $baseQuery;
    }

    public function scopeCustomSort(Builder $query, string $sortField, string $sortOrder): Builder
    {
        try {
            $query->clone()->orderBy($sortField, $sortOrder)->limit(1)->get();
        } catch (Throwable) {
            return $query;
        }

        return $query->orderBy($sortField, $sortOrder);
    }

    public function scopeCustomSearch(Builder $query, string $searchTerm): Builder
    {
        foreach ($this->searchable as $field) {
            $query->orWhere($field, 'LIKE', "%{$searchTerm}%");
        }

        return $query;
    }
}
