<?php
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class AgentDetails extends Model
{
	use HasFactory;
    use Sortable;
    protected $table = 'agent_details';

    protected $fillable = [
		'business_name',
		'agent_name',
		'marn_number',
		'legal_practitioner_number',
		'exempt_person_reason',
		'business_address',
		'business_phone',
		'business_mobile',
		'business_email',
		'business_fax',
        'status'
	];

	/**
     * Get the forms related to this agent.
     */
    public function forms(): HasMany
    {
        return $this->hasMany(Form956::class, 'agent_id');
    }


}


