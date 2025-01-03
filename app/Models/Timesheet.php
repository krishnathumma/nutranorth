<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'timesheets';

    protected $guarded = ['id'];

    protected $fillables = [];
}
