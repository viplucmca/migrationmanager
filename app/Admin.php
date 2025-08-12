<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;
	use Sortable;
	use HasFactory;

	// The authentication guard for admin
    protected $guard = 'admin';

	/**
      * The attributes that are mass assignable.
      *
      * @var array
	*/
	protected $fillable = [
        'id', 'role', 'first_name', 'last_name', 'email', 'password', 'decrypt_password', 'country', 'state', 'city', 'address', 'zip', 'profile_img', 'status', 'service_token', 'token_generated_at', 'created_at', 'updated_at'
    ];

	/**
      * The attributes that should be hidden for arrays.
      *
      * @var array
	*/
    protected $hidden = [
        'password', 'remember_token',
    ];

	public $sortable = ['id', 'first_name', 'last_name', 'email', 'created_at', 'updated_at'];

	public function countryData()
    {
        return $this->belongsTo('App\Country','country');
    }

	public function stateData()
    {
        return $this->belongsTo('App\State','state');
    }
	public function usertype()
    {
        return $this->belongsTo('App\UserRole', 'role', 'id');
    }


	/**
     * Get the forms related to this client.
     */
    public function forms(): HasMany
    {
        return $this->hasMany(Form956::class);
    }

    /**
     * Get full name
    */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
