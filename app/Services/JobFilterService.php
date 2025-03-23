<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class JobFilterService
{
    // This method is used to filter jobs based on all given filters
    public function applyFiltersAll($query, $filters, $perPage = 10) {
        // Apply filters
        $this->filterByJobType($query, $filters);
        $this->filterBySalary($query, $filters);
        $this->filterByLanguages($query, $filters);
        $this->filterByLocations($query, $filters);
        $this->filterByCategories($query, $filters);
        $this->filterByAttributes($query, $filters);
        
        // Filter by status (ensure only published jobs are shown)
        $query->where('status', 'published');
        // Paginate the results
        return $query->paginate($perPage);
    }

    // This method is used to filter jobs based on any given filter
    public function applyFiltersAny($query, $filters, $perPage = 10) {

        // Use OR conditions for filtering
        $query->where(function ($q) use ($filters) {
            $this->filterByJobType($q, $filters, 'or');
            $this->filterByLanguages($q, $filters, 'or');
            $this->filterByLocations($q, $filters, 'or');
            $this->filterByCategories($q, $filters, 'or');
            $this->filterByAttributes($q, $filters, 'or');
        });

        // Filter by status (ensure only published jobs are shown)
        $query->where('status', 'published');

        // Paginate the results
        return $query->paginate($perPage);
    }

    // Helper method to filter by job_type
    private function filterByJobType($query, $filters, $condition = 'and') {
        if (isset($filters['job_type'])) {
            $method = $condition === 'or' ? 'orWhere' : 'where';
            $query->$method('job_type', $filters['job_type']);
        }
    }

    // Helper method to filter by salary
    private function filterBySalary($query, $filters, $condition = 'and') {
        if (isset($filters['salary'])) {
            $method = $condition === 'or' ? 'orWhere' : 'where';
            $query->$method('salary_min', '<=', $filters['salary'])
                  ->$method('salary_max', '>=', $filters['salary']);
        }
    }

    // Helper method to filter by languages
    private function filterByLanguages($query, $filters, $condition = 'and') {
        if (isset($filters['languages'])) {
            Log::info('Filtering by languages:', $filters['languages']);
            $method = $condition === 'or' ? 'orWhereHas' : 'whereHas';
            $query->$method('languages', function ($q) use ($filters) {
                $q->whereIn('name', (array) $filters['languages']);
            });
        }
    }

    // Helper method to filter by locations
    private function filterByLocations($query, $filters, $condition = 'and') {
        if (isset($filters['locations'])) {
            Log::info('Filtering by locations:', $filters['locations']);
            $method = $condition === 'or' ? 'orWhereHas' : 'whereHas';
            $query->$method('locations', function ($q) use ($filters) {
                $q->whereIn('city', (array) $filters['locations']);
            });
        }
    }

    // Helper method to filter by categories
    private function filterByCategories($query, $filters, $condition = 'and') {
        if (isset($filters['categories'])) {
            Log::info('Filtering by categories:', $filters['categories']);
            $method = $condition === 'or' ? 'orWhereHas' : 'whereHas';
            $query->$method('categories', function ($q) use ($filters) {
                $q->whereIn('name', (array) $filters['categories']);
            });
        }
    }

    // Helper method to filter by attributes
    private function filterByAttributes($query, $filters, $condition = 'and') {
        if (isset($filters['attributes'])) {
            Log::info('Filtering by attributes:', $filters['attributes']);
            $attributes = is_array($filters['attributes']) ? $filters['attributes'] : [];

            foreach ($attributes as $attribute) {
                if (is_array($attribute) && isset($attribute['name']) && isset($attribute['value'])) {
                    $method = $condition === 'or' ? 'orWhereHas' : 'whereHas';
                    $query->$method('attributes', function ($q) use ($attribute) {
                        $q->where('name', $attribute['name'])
                          ->where('job_attribute_values.value', $attribute['value']);
                    });
                }
            }
        }
    }

    // Validate filters
    private function validateFilters($filters) {
        return validator($filters, [
            'job_type' => ['nullable', Rule::in(['full-time', 'part-time', 'contract', 'freelance'])],
            'salary' => 'nullable|numeric',
            'languages' => 'nullable|array',
            'languages.*' => 'string',
            'locations' => 'nullable|array',
            'locations.*' => 'string',
            'categories' => 'nullable|array',
            'categories.*' => 'string',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required|string',
            'attributes.*.value' => 'required|string',
        ])->validate();
    }
}