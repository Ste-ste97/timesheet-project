<?php

namespace App\Models;

use App\Models\Traits\BaseModelTrait;
use App\Models\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
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
        'full_name',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code',
    ];

    protected array $formColumns = [
        'full_name',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code',
    ];

    protected array $searchable = [
        'full_name',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code',
    ];
}
