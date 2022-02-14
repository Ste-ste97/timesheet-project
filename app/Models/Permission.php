<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $with = ['children'];

    protected $appends = ['type'];

    /**
     * Get the children for this permission.
     */
    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    public function getTypeAttribute()
    {
        return str_contains($this->name, '.') ? explode('.', $this->name)[1] : '';
    }
}
