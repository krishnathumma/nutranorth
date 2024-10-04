<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'suppliers';

    protected $guarded = ['id'];

    protected $fillables = ['name', 'place', 'product', 'email', 'currency', 'mobile', 'price'];
   

    /**
     * Get the user that owns the phone.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
