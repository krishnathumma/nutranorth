<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocationRelationship extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'user_location_relationship';

    protected $guarded = ['id'];
}
