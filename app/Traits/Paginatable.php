<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Paginatable
{
    public static function setUpQuery($request): Builder
    {
        $baseQuery = self::allRelations();

        $sortOrder = $request->input('sortOrder', null);
        if ($sortOrder != 'asc' && $sortOrder != 'desc' && $sortOrder != null) {
            $sortOrder = null;
        }

        $sortField      = $request->input('sortField', null);
        $sortableFields = self::getSortableFields();


        if ($sortField != null && $sortOrder != null) {
            $baseQuery = self::customSort($baseQuery, $sortField, $sortOrder);
        } else {
            if (!in_array($sortField, $sortableFields) && $sortField != null) {
                $sortField = null;
            }
        }

        $search = request('search', '');

        if ($search != '') {
            $baseQuery = self::customSearch($baseQuery, $search);
        }

        return $baseQuery;
    }

    //in case that the model doesn't contain the getSortableFields() and getSearchFields() methods.
    protected static function getSortableFields(): array
    {
        return [];
    }

    protected static function getSearchFields(): array
    {
        return [];
    }

    protected static function allRelations(): Builder
    {
        return self::query();
    }

    protected static function customSort(Builder $query, string $sortField, string $sortOrder): Builder
    {
        return $query->orderBy($sortField, $sortOrder);
    }

    protected static function customSearch(Builder $query, string $searchTerm): Builder
    {
        $searchFields = self::getSearchFields();
        foreach ($searchFields as $field) {
            $query->orWhere($field, 'LIKE', "%{$searchTerm}%");
        }

        return $query;
    }
}
