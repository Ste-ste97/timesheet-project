<?php
namespace App\Entities;

use App\Models\Navlink;

class Navbar
{

    public function getNavbar(): \Illuminate\Support\Collection {
        return Navlink::whereNull('parent_id')->get();
    }

}