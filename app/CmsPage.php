<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CmsPage extends Authenticatable
{
    use Notifiable;
	use Sortable;

	protected $fillable = [
        'id', 'title', 'alias', 'content', 'created_at', 'updated_at'
    ];
	
	public $sortable = ['id', 'title', 'created_at', 'updated_at'];
}