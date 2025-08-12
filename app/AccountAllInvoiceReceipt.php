<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AccountAllInvoiceReceipt extends Authenticatable
{
    use Notifiable;
	use Sortable;

}
