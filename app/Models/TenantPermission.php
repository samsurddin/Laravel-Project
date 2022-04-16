<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Permission\Models\Permission as BasePermission;
use Spatie\Multitenancy\Models\Tenant;

class TenantPermission extends BasePermission
{
    // use UsesLandlordConnection;
    
    protected $connection = 'tenant';

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);

        if (!Tenant::checkCurrent()) {
            $this->connection = 'landlord';
        }
        // dd($this->connection);
    }
}
