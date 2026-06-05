<?php

namespace App\Models;

use App\Models\AdministrativeModuleModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AdministrativeModel extends Authenticatable
{
   use Notifiable;

   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'up_administrative';

   /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
   protected $appends = ['name'];

   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = ['password', 'remember_token'];

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['firstname', 'lastname', 'department', 'email', 'password', 'avatar', 'status'];

   /**
    * Get the administrative's full name.
    *
    * @return string
    */
   public function getNameAttribute()
   {
      return "{$this->firstname} {$this->lastname}";
   }

   /**
    * Set the administrative password.
    *
    * @param string $value
    * @return void
    */
   public function setPasswordAttribute($value)
   {
      $value === null ?: $this->attributes['password'] = Hash::make($value);
   }

   /**
    * Set the administrative email.
    *
    * @param string $value
    * @return void
    */
   public function setCorreoAttribute($value)
   {
      $value === null ?: $this->attributes['correo'] = strtolower($value);
   }

   /**
    * Get the modules that owns the administrative.
    *
    * @return collection
    */
   public function modules()
   {
      return $this->hasMany(AdministrativeModuleModel::class, 'administrative_id');
   }
}