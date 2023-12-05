<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();

        if ($jobs->count() > 0) {
            return response()->json([
                'status' => 200,
                'jobs' => $jobs,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No jobs found',
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'company' => [
                'required',
                'string',
                'max:255',
            ],
            'state' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                'string',
                'max:255',
            ],
            'close_date' => [
                'nullable',
                'date',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $job = Job::create($request->all());

            if ($job) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Job created successfully.',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Job could not be created.',
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::find($id);

        if ($job) {
            return response()->json([
                'status' => 200,
                'job' => $job,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Job not found',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => [
                'nullable',
                'string',
                'max:255',
            ],
            'state' => [
                'nullable',
                'string',
                'max:255',
            ],
            'company' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $jobs = Job::where('status', $request->status)
                ->where('state', $request->state)
                ->where('company', $request->company)
                ->get();

            if ($jobs->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'jobs' => $jobs,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No jobs found',
                ], 404);
            }
        }
    }
}
