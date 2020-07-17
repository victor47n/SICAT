<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'problem_type', 'problem', 'realized_date', 'solution_problem', 'designated_employee', 'solver_employee',
        'locale_id', 'workstation_id', 'status_id',
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
}
