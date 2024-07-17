<?php


namespace App\Models\Traits;

use App\Helpers\ColumnTypeHelper;
use Throwable;

trait BaseModelTrait
{
    public function getModelRelationships(): array
    {
        try {
            return $this->relationships();
        } catch (Throwable $e) {
            return [];
        }
    }

    public static function getDataColumns($tableColumns = [], $formColumns = [], $excludedTableColumns = [], $excludedFormColumns = []): array
    {
        $self         = new static();
        $formColumns  = $formColumns === [] ? ($self->formColumns ?? []) : $formColumns;
        $tableColumns = $tableColumns === [] ? ($self->datatableColumns ?? []) : $tableColumns;

        if ($excludedTableColumns !== []) {
            $tableColumns = array_diff($tableColumns, $excludedTableColumns);
        }

        if ($excludedFormColumns !== []) {
            $formColumns = array_diff($formColumns, $excludedFormColumns);
        }

        return ColumnTypeHelper::getColumnsForTable(
            $self->getTable(),
            $formColumns,
            $tableColumns,
            $self->getHidden(),
        );
    }
}
