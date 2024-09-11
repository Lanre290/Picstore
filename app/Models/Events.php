<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'user';

    public $timestamps = false;

    protected $fillable = ['id', 'user_id', 'event_link', 'title'];
}
