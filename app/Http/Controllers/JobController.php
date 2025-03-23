<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobsResource;
use App\Models\Job;
use App\Services\JobFilterService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request) {
        $filters = $request->query('filter');
        $jobs = Job::query();
        $filterService = new JobFilterService();

        // Apply filters on all given filters
        // $filterService->applyFiltersAll($jobs, $filters);

        // Apply filters on any given filter
        $filterService->applyFiltersAny($jobs, $filters);

        return response()->json(JobsResource::collection($jobs->get()));
    }


}
