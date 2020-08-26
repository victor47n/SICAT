<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowedItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'borrowing_id', 'item_id', 'lender_id', 'receiver_id', 'status_id', 'amount', 'return_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
