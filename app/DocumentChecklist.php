<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DocumentChecklist extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = ['id', 'name','doc_type','status','created_at', 'updated_at'];

	public $sortable = ['id','created_at', 'updated_at'];

}
