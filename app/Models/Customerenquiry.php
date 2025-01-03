<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Customerenquiry extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $table = 'customer_enquiry';

    protected $guarded = ['id'];


    /**
     * Get the user that owns the phone.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
