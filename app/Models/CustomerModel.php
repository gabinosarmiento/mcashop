<?php

namespace App\Models;

use App\Models\CustomerAddressModel;
use App\Models\CustomerBillingModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomerModel extends Authenticatable
{
    use Notifiable;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'up_customer';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'phone', 'email', 'password', 'avatar', 'company', 'terms', 'status'];

    /**
     * Get the customer's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Set the customer's email.
     *
     * @param string $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Get the address record associated with the customer.
     */
    public function address()
    {
        return $this->hasOne(CustomerAddressModel::class, 'customer_id');
    }

    /**
     * Get the billing record associated with the customer.
     */
    public function billing()
    {
        return $this->hasOne(CustomerBillingModel::class, 'customer_id');
    }
}