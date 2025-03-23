<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model {
    protected $fillable = ['name', 'type', 'options'];

    public function jobs() {
        return $this->belongsToMany(Job::class, 'job_attribute_values')
                    ->withPivot('value'); // Include the pivot value
    }
}