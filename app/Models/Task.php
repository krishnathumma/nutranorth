<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'tasks';

    protected $guarded = ['id'];

    protected $fillables = ['task_category', 'task_type', 'assigned_to', 'source', 'status', 'assigned_date', 'due_time'];
   

    /**
     * Get the user that owns the phone.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
