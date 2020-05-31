<?php

namespace App;

use Spatie\Permission\Models\Role;

class ApiRole extends Role
{
    protected $guard_name = 'api';
}
