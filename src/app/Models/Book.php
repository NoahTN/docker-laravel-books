<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = true;
    /**
     * Field to be mass-assigned.
     *
     * @var array
     */
    protected $fillable = ['title', 'author'];
}
