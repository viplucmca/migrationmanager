<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Document extends Authenticatable
{
    use Notifiable;
	use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function signers()
    {
        return $this->hasMany(Signer::class);
    }

    public function signatureFields()
    {
        return $this->hasMany(SignatureField::class);
    }

}
