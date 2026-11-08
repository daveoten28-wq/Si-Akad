<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T013User extends Model
{
    use HasFactory;

    protected $table = 't013_users';
    protected $primaryKey = 't013_user_id';
    protected $fillable = ['t013_username', 't013_password', 't013_role_id'];
}