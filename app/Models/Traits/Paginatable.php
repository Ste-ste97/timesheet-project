<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Str;
use Throwable;

trait Paginatable
{
    private const ASC  = 'asc';
    private const DESC = 'desc';

    public function scopeSetUpQuery(Builder $baseQuery): Builder
    {
        $baseQuery->with($this->getModelRelationships());

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
            $baseQuery = $baseQuery->customSearch($search);
        }

        return $baseQuery;
    }

    public function scopeCustomSort(Builder $query, string $sortField, string $sortOrder): Builder
    {
        if ($this->tryDefinedSort($query, $sortField, $sortOrder)) {
            $function = Str::camel(str_replace('.', '_', $sortField)) . 'Sort';
            return $query->$function($sortOrder);
        }

        if (str_contains($sortField, '.') && $this->tryRelationSort($query, $sortField, $sortOrder)) {
            $relationship = explode('.', $sortField)[0];
            $related      = $this->$relationship()->getRelated();
            return $query->leftJoin("{$related->getTable()} AS $relationship", "{$this->getTable()}.{$this->$relationship()->getLocalKeyName()}", '=', "$relationship.{$related->getKeyName()}")
                         ->orderBy($sortField, $sortOrder);
        }

        if ($this->tryBaseTableSort($query, $sortField, $sortOrder)) {
            return $query->orderBy($sortField, $sortOrder);
        }

        return $query;
    }


    public function scopeCustomSearch(Builder $query, string $searchTerm): Builder
    {
        foreach ($this->searchable as $key => $value) {
            if (str_contains($this->searchable[$key], '.')) {
                if ($key === 0) {
                    $query->whereHas(explode('.', $value)[0], function ($q) use ($searchTerm, $value) {
                        $q->Where(explode('.', $value)[1], 'like', '%' . $searchTerm . '%');
                    });
                } else {
                    $query->orWhereHas(explode('.', $value)[0], function ($q) use ($searchTerm, $value) {
                        $q->Where(explode('.', $value)[1], 'like', '%' . $searchTerm . '%');
                    });
                }
            } elseif ($key === 0) {
                $query->where($value, 'like', '%' . $searchTerm . '%');
            } else {
                $query->orWhere($value, 'like', '%' . $searchTerm . '%');
            }
        }

        return $query;
    }

    private function tryBaseTableSort($query, $sortField, $sortOrder): bool
    {
        try {
            $query->clone()->orderBy($sortField, $sortOrder)->limit(1)->get();
        } catch (Throwable) {
            return false;
        }

        return true;
    }

    private function tryRelationSort($query, $sortField, $sortOrder): bool
    {
        try {
            $relationship = explode('.', $sortField)[0];
            $related      = $this->$relationship()->getRelated();
            $query->clone()->leftJoin("{$related->getTable()} AS $relationship", "{$this->getTable()}.{$this->$relationship()->getLocalKeyName()}", '=', "$relationship.{$related->getKeyName()}")
                  ->orderBy($sortField, $sortOrder)->limit(1)->get();
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }

    private function tryDefinedSort($query, $sortField, $sortOrder): bool
    {
        try {
            $function = Str::camel(str_replace('.', '_', $sortField)) . 'Sort';
            $query->clone()->$function($sortOrder)->limit(1)->get();
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }
}
