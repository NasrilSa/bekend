<?php

namespace App\Http\Controllers;

use App\Models\school;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */     public function showAll()
    {
        $school = school::with(['city'])->get();
        return response()->json($school);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required"

        ]);

        $school = $request->name;
        $city_id = $request->city_id;

        $existSchool = school::where('name', $school)->first();
        if ($existSchool) {
            return response()->json([
                "message" => "school with name $school is already exist",
                "data" => $school
            ]);
        }

        $saveSchool = school::create([
            "name" => $school,
            "city_id" => $city_id
        ]);
        if ($saveSchool) {
            return response()->json([
                "message" => "School succesfully created",
                "data" => [$school, $city_id]
            ]);
        } else {
            return response()->json([
                "message" => "failed to add school",
                "data" => null
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function schoolDetail(string $id)
    {
        $school = school::with(['city', 'student_class'])->find($id);

        return response()->json($school);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $school =  school::find($id);
        if ($school) {
            $schoolName = $request->name;
            $school->update([
                "name" => $schoolName
            ]);
            return response()->json([
                "message" => "school succesfully updated to $schoolName",
                "data" => [$school, $schoolName]
            ]);
        } else {
            return response()->json([
                "message" => "school not found",
                "data" => null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteSchool(string $id)
    {
        $school = school::find($id);
        if ($school) {
            $school->delete();
            return response()->json([
                "message" => "School  has been deleted."
            ]);
        } else {
            return response()->json([
                "message" => "School not found, so not deleted."
            ]);
        }
    }
}
