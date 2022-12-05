<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Tenant;

class Customer extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    // protected $table = 'customer';
    // protected $fillable = [
       // 'username', 
        //'useradress', 
        //'usercity', 
        //'userage'
    //];

    //public function user(){
      //  return $this->hasOne(User::class);
    //}
    
}
