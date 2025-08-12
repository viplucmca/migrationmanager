<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPassportInformation extends Model
{
    protected $table = 'client_passport_informations'; // The name of the table

    protected $fillable = [
        'client_id',
        'admin_id',
        'passport',
        'passport_issue_date',
        'passport_expiry_date'
    ];
}


