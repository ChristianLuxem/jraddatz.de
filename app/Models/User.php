<?php

namespace JRaddatz\Web\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @package LoginSystem\Models
 */
class User extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'key',
    ];

}
