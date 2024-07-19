<?php

namespace App\Models;

use App\Models\Traits\BaseModelTrait;
use App\Models\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory, Paginatable, BaseModelTrait;

    protected $guarded = ['id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
    ];


    protected array $datatableColumns = [
        'id',
        'name',
    ];

    protected array $formColumns = [
        'name',
    ];

    protected array $searchable = [
        'id',
        'name',
    ];

    public function companyUserTimesheets(): HasMany
    {
        return $this->hasMany(CompanyUserTimeSheet::class, 'company_id', 'id');
    }



}
