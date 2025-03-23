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
        $filterMode = $request->query('filter_mode', 'any');
        $jobs = Job::query();
        $filterService = new JobFilterService();

        // Apply filters based on the filter mode
        if ($filterMode === 'all') {
            $filterService->applyFiltersAll($jobs, $filters);
        } else {
            $filterService->applyFiltersAny($jobs, $filters);
        }
        return response()->json(JobsResource::collection($jobs->get()));
    }


}
