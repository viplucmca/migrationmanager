<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsiblePerson extends Model
{
    use HasFactory;
	protected $table = 'responsible_people';

    protected $fillable = [
        'business_name', 'abn', 'contact_address_street', 'contact_address_suburb',
        'contact_address_state', 'contact_address_postcode', 'email', 'phone',
        'prefix', 'given_names', 'surname', 'mara_number',
    ];
}
