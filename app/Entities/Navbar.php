<?php
namespace App\Entities;

use App\Models\Navlink;

class Navbar
{

    public function getNavbar() {
        return Navlink::whereNull('parent_id')->get();
    }

}