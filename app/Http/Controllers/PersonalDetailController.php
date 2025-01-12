<?php

namespace App\Http\Controllers;

use App\Models\PersonalDetail;
use Illuminate\Http\Request;

class PersonalDetailController extends Controller
{
    /**
     * Display a listing of personal details.
     */
    public function index()
    {
        return response()->json(PersonalDetail::all());
    }

    /**
     * Store a newly created personal detail in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'application_number' => 'required|unique:personal_details',
            'surname' => 'required|string',
            'other_names' => 'required|string',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'state_of_origin' => 'required|string',
            'local_government' => 'required|string',
            'ethnic_group' => 'nullable|string',
            'religion' => 'required|string',
            'name_of_father' => 'required|string',
            'father_state_of_origin' => 'required|string',
            'father_place_of_birth' => 'required|string',
            'mother_state_of_origin' => 'required|string',
            'mother_place_of_birth' => 'required|string',
            'applicant_occupation' => 'required|string',
            'desired_study_cent' => 'required|string',
            'working_experience' => 'nullable|string',
            'has_paid' => 'nullable|string',
            'application_date'  => 'nullable|date',
            'application_trxid' => 'nullable|string',
            'application_reference' => 'nullable|string',
            'has_admission' => 'nullable|string',
            'matric_number' => 'nullable|string',
        ]);

        $personalDetail = PersonalDetail::create($validatedData);

        return response()->json($personalDetail, 201);
    }

    /**
     * Display the specified personal detail.
     */
    public function show($id)
    {
        $personalDetail = PersonalDetail::where('application_number', $id)->first();
        return response()->json($personalDetail);
    }

    public function find(Request $request)
    {

        $applicationNumber = $request->input('application_number');

        $personalDetail = PersonalDetail::where('application_number', $applicationNumber)->first();
        if ($personalDetail){

            return response()->json($personalDetail);
        } else{
          return response()->json(['message' => 'Student not found'], 404);

        }
    }

    /**
     * Update the specified personal detail in storage.
     */
    public function update(Request $request, $id)
    {
        $personalDetail = PersonalDetail::findOrFail($id);

        $validatedData = $request->validate([
            'application_number' => 'sometimes|unique:personal_details,application_number,' . $id,
            'surname' => 'sometimes|string',
            'other_names' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
            'marital_status' => 'sometimes|string',
            'phone_number' => 'sometimes|string',
            'address' => 'sometimes|string',
            'state_of_origin' => 'sometimes|string',
            'local_government' => 'sometimes|string',
            'ethnic_group' => 'nullable|string',
            'religion' => 'sometimes|string',
            'name_of_father' => 'sometimes|string',
            'father_state_of_origin' => 'sometimes|string',
            'father_place_of_birth' => 'sometimes|string',
            'mother_state_of_origin' => 'sometimes|string',
            'mother_place_of_birth' => 'sometimes|string',
            'applicant_occupation' => 'sometimes|string',
            'desired_study_cent' => 'sometimes|string',
            'working_experience' => 'nullable|string',
        ]);

        $personalDetail->update($validatedData);

        return response()->json($personalDetail);
    }

    /**
     * Remove the specified personal detail from storage.
     */
    public function destroy($id)
    {
        $personalDetail = PersonalDetail::findOrFail($id);
        $personalDetail->delete();

        return response()->json(['message' => 'Personal detail deleted successfully.']);
    }
}
