<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Permission\Models\Role as BaseRole;
use Spatie\Multitenancy\Models\Tenant;

class TenantRole extends BaseRole
{
    // use UsesLandlordConnection;
    
    protected $connection = 'tenant';

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);

        if (!Tenant::checkCurrent()) {
            $this->connection = 'landlord';
        }
        // dd(Tenant::checkCurrent());
        // dd($this->connection);
    }

}