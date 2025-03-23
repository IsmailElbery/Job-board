<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Language;
use App\Models\Location;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\JobAttributeValue;

class JobBoardSeeder extends Seeder
{
    public function run()
    {
        // Seed Languages
        $languages = [
            ['name' => 'PHP'],
            ['name' => 'JavaScript'],
            ['name' => 'Python'],
            ['name' => 'Java'],
        ];
        Language::insert($languages);

        // Seed Locations
        $locations = [
            ['city' => 'New York', 'state' => 'NY', 'country' => 'USA'],
            ['city' => 'San Francisco', 'state' => 'CA', 'country' => 'USA'],
            ['city' => 'Remote', 'state' => 'N/A', 'country' => 'Global'],
        ];
        Location::insert($locations);

        // Seed Categories
        $categories = [
            ['name' => 'Web Development'],
            ['name' => 'Mobile Development'],
            ['name' => 'Data Science'],
        ];
        Category::insert($categories);

        // Seed Attributes
        $attributes = [
            ['name' => 'years_experience', 'type' => 'number', 'options' => null],
            ['name' => 'education_level', 'type' => 'select', 'options' => json_encode(['Bachelor', 'Master', 'PhD'])],
            ['name' => 'is_urgent', 'type' => 'boolean', 'options' => null],
        ];
        Attribute::insert($attributes);

        // Seed Jobs
        $jobs = [
            [
                'title' => 'Senior PHP Developer',
                'description' => 'Looking for an experienced PHP developer.',
                'company_name' => 'Tech Corp',
                'salary_min' => 5000.00,
                'salary_max' => 7000.00,
                'is_remote' => true,
                'job_type' => 'full-time',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'JavaScript Developer',
                'description' => 'Looking for a skilled JavaScript developer.',
                'company_name' => 'Web Solutions',
                'salary_min' => 4000.00,
                'salary_max' => 6000.00,
                'is_remote' => false,
                'job_type' => 'part-time',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'Data Scientist',
                'description' => 'Looking for a data scientist with Python experience.',
                'company_name' => 'Data Insights',
                'salary_min' => 6000.00,
                'salary_max' => 8000.00,
                'is_remote' => true,
                'job_type' => 'contract',
                'status' => 'published',
                'published_at' => now(),
            ],
        ];
        Job::insert($jobs);

        // Attach Relationships
        $job1 = Job::find(1);
        $job1->languages()->attach([1, 2]); // PHP, JavaScript
        $job1->locations()->attach([1, 3]); // New York, Remote
        $job1->categories()->attach(1); // Web Development

        $job2 = Job::find(2);
        $job2->languages()->attach([2]); // JavaScript
        $job2->locations()->attach([2]); // San Francisco
        $job2->categories()->attach(1); // Web Development

        $job3 = Job::find(3);
        $job3->languages()->attach([3]); // Python
        $job3->locations()->attach([3]); // Remote
        $job3->categories()->attach(3); // Data Science

        // Seed Job Attribute Values
        JobAttributeValue::insert([
            [
                'job_id' => 1,
                'attribute_id' => 1, // years_experience
                'value' => '5',
            ],
            [
                'job_id' => 1,
                'attribute_id' => 2, // education_level
                'value' => 'Bachelor',
            ],
            [
                'job_id' => 2,
                'attribute_id' => 1, // years_experience
                'value' => '3',
            ],
            [
                'job_id' => 3,
                'attribute_id' => 3, // is_urgent
                'value' => 'true',
            ],
        ]);
    }
}