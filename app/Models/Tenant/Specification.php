<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'head_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Specification::class, 'head_id');
    }

    public function child()
    {
        return $this->hasMany(Specification::class, 'head_id');
    }

    public function scopeHeads($query)
    {
        return $query->where('type', '=', 'head')->where('head_id', '=', NULL);
    }
}
