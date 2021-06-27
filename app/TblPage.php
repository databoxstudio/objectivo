<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblPage extends Model
{
     protected $fillable = [
        'title', 'content', 'status',
    ];
}
