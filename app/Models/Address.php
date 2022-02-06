<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'street_name',
        'street_num',
        'state',
        'postal_code'
    ];

    /**
     * Get the city for this address.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the country for this address.
     */
    public function country()
    {
        return $this->city->country();
    }
}
