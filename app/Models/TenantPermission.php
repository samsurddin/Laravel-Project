<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Permission\Models\Permission as BasePermission;

class TenantPermission extends BasePermission
{
    use UsesLandlordConnection;
}
