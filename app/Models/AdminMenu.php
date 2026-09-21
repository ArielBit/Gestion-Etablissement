<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminMenu
 * 
 * @property int $id
 * @property int $parent_id
 * @property int $order
 * @property string $title
 * @property string $icon
 * @property string|null $uri
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AdminMenu extends Model
{
	protected $table = 'admin_menu';

	protected $casts = [
		'parent_id' => 'int',
		'order' => 'int'
	];

	protected $fillable = [
		'parent_id',
		'order',
		'title',
		'icon',
		'uri'
	];
}
