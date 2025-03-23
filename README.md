<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Job Board API

This is a Laravel-based API for managing job listings with advanced filtering capabilities. It supports two types of filtering: AND-based filtering (all filters must match) and OR-based filtering (any filter can match).


Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Features

Job Management:

    - Create, read, update, and delete job listings.

    - Each job has attributes like title, description, company_name, salary_min, salary_max, is_remote, job_type, status, and published_at.

Advanced Filtering:

    Filter jobs by:
    
        Job Type: full-time, part-time, contract, freelance.

        Salary Range: Filter by minimum and maximum salary.

        Languages: Filter by required programming languages.

        Locations: Filter by job locations.

        Categories: Filter by job categories.

        Dynamic Attributes: Filter by custom attributes using the Entity-Attribute-Value (EAV) pattern.

Two Filtering Modes:

    All Filters: Jobs must match all the specified filters (AND logic).

    Any Filter: Jobs must match any of the specified filters (OR logic).

## Installation

1. Clone the Repository
    git clone https://github.com/your-username/job-board.git
    cd job-board

2. Install Dependencies   
    composer install

3. Set Up the Environment    
    - cp .env.example .env  
    - Update the .env file with your database credentials:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=job_board
        DB_USERNAME=root
        DB_PASSWORD=  

4. Generate Application Key
    php artisan key:generate

5. Run Migrations
    php artisan migrate

6. Seed the Database
    php artisan db:seed

7. Start the Development Server
    php artisan serve

The API will be available at http://127.0.0.1:8000        

### API Endpoints

Get All Jobs
    URL: /api/jobs

    Method: GET

    Description: Retrieve a list of jobs with optional filtering.

    Query Parameters:

    filter[job_type]: Filter by job type (e.g., full-time, part-time).

    filter[salary]: Filter by salary range (e.g., 4000).

    filter[languages][]: Filter by programming languages (e.g., PHP, JavaScript).

    filter[locations][]: Filter by locations (e.g., New York, Remote).

    filter[categories][]: Filter by categories (e.g., Web Development).

    filter[attributes][attribute_name]: Filter by dynamic attributes (e.g., years_experience=3).

    filter_mode: Choose between all (AND logic) or any (OR logic). Default is any.

    per_page: Number of items per page (e.g., 10). Default is 10.

Example Requests
    1- Filter by All:    
        GET /api/jobs?filter[job_type]=part-time&filter[salary]=4000&filter[languages][]=PHP&filter[languages][]=JavaScript&filter[locations][]=Remote&filter[attributes][years_experience]=3&filter[locations][]=San Francisco
    2- Filter by Locations or Categories (OR Logic):
        GET /api/jobs?filter[locations][]=New York&filter[locations][]=Remote&filter[categories][]=Web Development&filter_mode=any    
    3- Filter by Salary and Dynamic Attribute:
        GET /api/jobs?filter[salary]=5000&filter[attributes][years_experience]=3


## Filtering Modes

1. All Filters (AND Logic)
    Jobs must match all the specified filters. Use filter_mode=all in the query parameters.

    Example:
    GET /api/jobs?filter[job_type]=full-time&filter[languages][]=PHP&filter_mode=all
    This will return jobs that:

    Have a job_type of full-time AND

    Require PHP as a language.
        

2. Any Filter (OR Logic) 
Jobs must match any of the specified filters. Use filter_mode=any in the query parameters (default).

        Example:
        GET /api/jobs?filter[job_type]=part-time&filter[languages][]=JavaScript&filter_mode=any
        
        This will return jobs that:

        Have a job_type of part-time OR

        Require JavaScript as a language. 

## Database Schema
Tables
1. jobs:

    id, title, description, company_name, salary_min, salary_max, is_remote, job_type, status, published_at, created_at, updated_at.

2. languages:

    id, name.

3. locations:

    id, city, state, country.

4. categories:

    id, name.

5. attributes:

    id, name, type, options.

6. job_attribute_values:

    id, job_id, attribute_id, value.

7. Pivot Tables:

    job_language, job_location, job_category.


## Seeded Data

The database seeder creates the following sample data:

Jobs: 3 sample job listings.

Languages: PHP, JavaScript, Python, Java.

Locations: New York, San Francisco, Remote.

Categories: Web Development, Mobile Development, Data Science.

Attributes: years_experience, education_level, is_urgent.
## Testing

You can test the API using tools like Postman
Example Requests
1. Get All Jobs:
    GET http://127.0.0.1:8000/api/jobs
2. Filter by Job Type and Languages:
    GET http://127.0.0.1:8000/api/jobs?filter[job_type]=full-time&filter[languages][]=PHP&filter[languages][]=JavaScript
3. Filter by Locations or Categories:
    GET http://127.0.0.1:8000/api/jobs?filter[locations][]=New York&filter[locations][]=Remote&filter[categories][]=Web Development&filter_mode=any        
## License

This project is open-source and available under the MIT License.
## Contact

For questions or feedback, please contact [Ismail] at [ismail.bery@gmail.com].