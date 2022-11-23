<?php

namespace Delgont\Cms\Models\Account;

use Illuminate\Database\Eloquent\Model;

class AccountNotifications extends Model
{
    protected $table = 'notifications';

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = ['read_at'];
}
