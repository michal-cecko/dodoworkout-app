<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;

interface Viewable
{
    function permalink() : Attribute;
}
