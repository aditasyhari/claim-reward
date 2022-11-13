<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimUserDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'claim_user_detail';
    protected $guarded = [];
    public $timestamps = false;
}
