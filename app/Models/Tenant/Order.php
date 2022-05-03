<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'has_billing_info',
        'accept_tc',
    ];

    protected $appends = [
        'short_order_number', 
        'shipping_full_address', 
        'billing_full_address', 
        'shipping_city_name', 
        'shipping_state_name',
        'billing_city_name', 
        'billing_state_name',
        // 'latest_status',
        'updated_at_human',
    ];

    protected $order_cities = [];
    protected $order_states = [];

    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    public function order_items()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')->withPivot('name', 'thumb', 'regular_price', 'sale_price', 'quantity', 'price', 'item_total');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
        // ->withPivot('name', 'thumb', 'regular_price', 'sale_price', 'quantity', 'price', 'item_total');
    }

    public function getShortOrderNumberAttribute()
    {
        $order_number = explode('-', $this->order_number);
        // return end($order_number);
        return $order_number[0];
    }

    public function getIsPaidAttribute($value)
    {
        switch ($value) {
            case 0:
                return 'Due';
                break;
            
            case 1:
                return 'Paid';
                break;
            
            case 2:
                return 'Partially Paid';
                break;
            
            default:
                return 'N/A';
                break;
        }
    }

    public function getChargesAttribute($value)
    {
        return json_decode($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    // public function getPaymentMethodAttribute($value)
    // {
    //     return Str::headline($value);
    // }

    public function getUpdatedAtHumanAttribute()
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function getShippingFullAddressAttribute()
    {
        $this->getLocRelativeData();
        // $city = $this->getShippingCityNameAttribute();
        // $state = $this->getShippingStateNameAttribute();

        // dd($this->getRelativeData('shipping_state', 'name', 'shipping_state'));
        return $this->shipping_fullname . "<br>" 
                . $this->shipping_address . ', <br>' 
                . $this->order_cities[$this->shipping_city] . ', <br>' 
                . $this->order_states[$this->shipping_state] . ', <br>' 
                . $this->shipping_zipcode;
                // . "<br> phone: " 
                // . $this->shipping_mobile;
    }

    public function getBillingFullAddressAttribute()
    {
        return $this->billing_fullname . "<br>" 
                . $this->billing_address . ', <br>' 
                . $this->order_cities[$this->billing_city] . ', <br>' 
                . $this->order_states[$this->billing_state] . ', <br>' 
                . $this->billing_zipcode;
                // . "<br> phone: " 
                // . $this->billing_mobile;
    }

    public function getShippingCityNameAttribute()
    {
        return $this->order_cities[$this->shipping_city];
    }

    public function getShippingStateNameAttribute()
    {
        return $this->order_states[$this->shipping_state];
    }

    public function getBillingCityNameAttribute()
    {
        return $this->order_cities[$this->billing_city];
    }

    public function getBillingStateNameAttribute()
    {
        return $this->order_states[$this->billing_state];
    }

    public function getLatestStatusAttribute()
    {
        $tracking = $this->tracking('desc')->limit(1)->pluck('title');
        return !empty($tracking)?$tracking[0]:'No results';
    }

    public function getRelativeData($relation, $field, $seach_value=NULL)
    {
        // dd($relation, $field, $seach_value, $this->$relation()->select($field)->get()->toArray()[0][$field]);

        // $data = $this->$relation()->select($field)->get();
        // $data = $this->$relation()->select($field)->find($this->$seach_value);
        // $data = $data->toArray();
        // dd($data, !empty($data));
        // dd($data, isset($data[0])?$data[0][$field]:$data[$field]);

        // $this->shipping_state()->select('name')->find($this->shipping_state)->toArray();
        if (empty($seach_value)) {
            $data = $this->$relation()->select($field)->get();
        }
        $data = $this->$relation()->select($field)->find($this->$seach_value);

        if (!empty($data)) {
            $data = $data->toArray();
            return isset($data[0])?$data[0][$field]:$data[$field];
        }
    }

    public function getLocRelativeData()
    {
        $this->order_cities = District::whereIn('id',[$this->shipping_city, $this->billing_city])->pluck('name', 'id');
        $this->order_states = Division::whereIn('id',[$this->shipping_state, $this->billing_state])->pluck('name', 'id');
        // dd($this->order_cities, $this->order_states);
    }

    // public function charges()
    // {
    //     return $this->hasMany(Charge::class);
    // }

    public function charges()
    {
        return $this->belongsToMany(Charge::class, 'order_charges', 'order_id', 'charge_id')->withPivot('charge_amount');
    }

    public function tracking($latest='asc')
    {
        return $this->belongsToMany(OrderStatus::class, 'order_trackings', 'order_id', 'order_status_id')->withPivot('date', 'note', 'show_on_tracking')->orderBy('order_trackings.date', $latest)->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }

    public function latest_status()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_trackings', 'order_id', 'order_status_id')->latest('order_trackings.created_at')->limit(1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipping_city()
    {
        return $this->belongsTo(District::class, 'shipping_city', 'id');
    }

    public function shipping_state()
    {
        return $this->belongsTo(Division::class, 'shipping_state', 'id');
    }

    public function shipping_zipcode()
    {
        return $this->belongsTo(Postcode::class, 'shipping_zipcode', 'postCode');
    }

    public function billing_city()
    {
        return $this->belongsTo(District::class, 'billing_city', 'id');
    }

    public function billing_state()
    {
        return $this->belongsTo(Division::class, 'billing_state', 'id');
    }

    public function billing_zipcode()
    {
        return $this->belongsTo(Postcode::class, 'billing_zipcode', 'postCode');
    }
}
