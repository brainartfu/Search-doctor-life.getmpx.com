<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchList extends Model
{
    use HasFactory;
    public $table = "oun_match_list";
    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'post_id',
        'fname',
        'lname',
        'phone',
        'zipcode',
        'email',
        'status',
    ];
}