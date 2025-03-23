<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model {
    protected $fillable = ['title', 'description', 'company_name', 'salary_min', 'salary_max', 'is_remote', 'job_type', 'status', 'published_at'];

    // Relationships
    public function languages() {
        return $this->belongsToMany(Language::class);
    }

    public function locations() {
        return $this->belongsToMany(Location::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'job_category' );
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class, 'job_attribute_values')
                    ->withPivot('value'); // Include the pivot value
    }
}
