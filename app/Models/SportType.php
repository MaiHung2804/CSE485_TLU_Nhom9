<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function courts()
    {
        return $this->hasMany(Court::class);
    }
}
