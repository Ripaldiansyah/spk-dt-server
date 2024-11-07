<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $guarded = [];
    use HasFactory;

    protected $table = 'train';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
