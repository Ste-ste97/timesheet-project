<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navlink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon',
        'permissions',
        'route_name',
        'parent_id'
    ];

    protected $with = ['children'];


    /**
     * Get the children for this navlink.
     */
    public function children()
    {
        return $this->hasMany(Navlink::class, 'parent_id');
    }


}
