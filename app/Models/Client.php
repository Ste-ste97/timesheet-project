<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModelTrait;
use App\Models\Traits\Paginatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Client extends Model
{
    use BaseModelTrait, Paginatable, HasFactory;

    protected $table = 'clients';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'is_private',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code'
    ];

    protected array $datatableColumns = [
        'id',
        'name',
        'is_private',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code'
    ];

    protected array $formColumns = [
        'name',
        'is_private',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code',
        'users'
    ];

    protected array $searchable = [
        'name',
        'is_private',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code'
    ];

    protected array $sortable = [
        'id',
        'name',
        'is_private',
        'mobile_phone',
        'landline_phone',
        'address',
        'fax',
        'email',
        'postal_code'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class, 'client_id');
    }

    public static function relationships(): array
    {
        return [
            'users',
            'timesheets'
        ];
    }

}
