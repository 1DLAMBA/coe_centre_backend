<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Store data in the applications table.
     */
    public function store(Request $request)
    {
        // Use mass assignment to save data
        $application = Application::create($request->all());

        return response()->json(['message' => 'Application saved successfully!', 'data' => $application], 201);
    }

    /**
     * Fetch all applications.
     */
    public function index()
    {
        $applications = Application::all();

        return response()->json(['data' => $applications], 200);
    }

    public function studentCheck(Request $request)
    {
        try {
            $applicationNumber = $request->input('application_number');

            $application = Application::where('application_number', $applicationNumber)->first();

            if ($application) {
                return response()->json(['message' => 'Student email FOUND', 'id' => $application], 200);
            }

            return response()->json(['message' => 'Email not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to check student', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $application = Application::find($id);

            if (!$application) {
                return response()->json(['message' => 'Application not found'], 404);
            }

            $application->update($request->all());
            return response()->json(['message' => 'Application updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update application', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $application = Application::find($id);

            if (!$application) {
                return response()->json(['message' => 'Application not found'], 404);
            }

            return response()->json($application, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch application', 'error' => $e->getMessage()], 500);
        }
    }
}
