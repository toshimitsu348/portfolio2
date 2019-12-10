<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'post_id'];
}
