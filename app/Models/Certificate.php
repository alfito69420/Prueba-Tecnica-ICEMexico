<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }
}
