<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimUser extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'claim_user';
    protected $guarded = [];
    public $timestamps = false;
}
