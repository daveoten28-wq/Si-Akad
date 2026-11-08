<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T013Role extends Model
{
    use HasFactory;

    protected $table = 't013_roles';
    protected $primaryKey = 't013_role_id';
    protected $fillable = ['t013_role_name'];
}