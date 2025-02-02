<?php

namespace App\Http\Controllers;

use App\Models\PersonalDetail;
use App\Models\StudentDetail;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class PersonalDetailController extends Controller
{
    /**
     * Display a listing of personal details.
     */
    public function index()
    {
        return response()->json(PersonalDetail::all());
    }

    public function import(String $centre,Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new StudentsImport($centre), $request->file('file'));

        return response()->json(['message' => 'Data imported successfully'], 200);
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
            'phone_number' => 'required',
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
            'email' => 'nullable|string',
            'passport' => 'nullable|string',
            'nin' => 'nullable|string',
            'olevel1' => 'nullable|string',
            'scratchcard_pin_1' => 'nullable|string',
            'scratchcard_serial' => 'nullable|string',
            'scratchcard_upload' => 'nullable|string',
        ]);

        $personalDetail = PersonalDetail::create($validatedData);

        return response()->json($personalDetail, 201);
    }

    /**
     * Display the specified personal detail.
     */
    public function show(string $id)
    {
        $personalDetail = PersonalDetail::with('studentDetail')->where('id', $id)->first();
        return response()->json($personalDetail->load('studentDetail'));
    }
    
    public function approve(string $id)
    {
        $personalDetail = PersonalDetail::where('id', $id)->first();
        $studentDetails = StudentDetail::where('application_number', $id)->first();
        $personalDetail->has_admission = true;
        $personalDetail->course = $studentDetails->first_course;
        $personalDetail->save();
        return response()->json($personalDetail->load('studentDetail'));
    }

    public function find(Request $request)
    {

        $applicationNumber = $request->input('application_number');

        $personalDetail = PersonalDetail::where('application_number', $applicationNumber)->first();
        if ($personalDetail){

            if ($personalDetail->has_admission){
    
                if( $personalDetail->matric_number){
    
                    return response()->json($personalDetail);
                } else{
              return response()->json(['message' => 'acceptance', 'user'=>$personalDetail], 200);
    
                     
                }
    
            } else{
              return response()->json(['message' => 'pending'], 425);
    
            }
        } else{
            return response()->json(['message' => 'Student not found'], 404);
  
          }
    }

    /**
     * Update the specified personal detail in storage.
     */
    public function update(Request $request, $id)
    {
        $personalDetail = PersonalDetail::where('id',$id)->first();

        $validatedData = $request->validate([
            'surname' => 'sometimes',
            'other_names' => 'sometimes',
            'date_of_birth' => 'sometimes|date',
            'marital_status' => 'sometimes',
            'phone_number' => 'sometimes',
            'address' => 'sometimes',
            'state_of_origin' => 'sometimes',
            'local_government' => 'sometimes',
            'ethnic_group' => 'nullable',
            'religion' => 'sometimes',
            'name_of_father' => 'sometimes',
            'father_state_of_origin' => 'sometimes',
            'father_place_of_birth' => 'sometimes',
            'mother_state_of_origin' => 'sometimes',
            'mother_place_of_birth' => 'sometimes',
            'applicant_occupation' => 'sometimes',
            'desired_study_cent' => 'sometimes',
            'has_admission' => 'sometimes',
            'matric_number' => 'sometimes',
            'application_reference' => 'sometimes',
            'application_trxid' => 'sometimes',
            'application_date' => 'sometimes',
            'working_experience' => 'nullable',
            'course_paid' => 'nullable',
            'email' => 'nullable',
            'course_fee_reference' => 'nullable',
            'couse_fee_date' => 'nullable',
            'nin' => 'nullable|string',
            'olevel1' => 'nullable|string',
            'scratchcard_pin_1' => 'nullable|string',
            'scratchcard_serial' => 'nullable|string',
            'scratchcard_upload' => 'nullable|string',
        ]);
    Log::info('Validated Data:', $validatedData);
    if($personalDetail->matric_number == null){

        $matricNumber = PersonalDetail::generateMatricNumber($personalDetail->course, $personalDetail->desired_study_cent);
        $personalDetail->matric_number = $matricNumber;
        $personalDetail->application_number = $matricNumber;
        $personalDetail->application_reference = $validatedData['application_reference'];
        // $personalDetail->matric_number = $matricNumber;
        $personalDetail->save();

        return response()->json($personalDetail);

    } else{
        $personalDetail->update($validatedData);

        return response()->json($personalDetail);
    }

        
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
