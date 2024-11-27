<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\student_class;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAll()
    {
        $class = student_class::with('school')->get();
        return response()->json($class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);
        $school_id = $request->school_id;
        $className = $request->name;

        $saveClass = student_class::create([
            "name" => $className,
            "school_id" => $school_id
        ]);
        if ($saveClass) {
            return response()->json([
                "message" => "class with name $className created",
                "data" => $saveClass
            ], 200);
        } else {
            return response()->json([
                "message" => "gagal menyimpan"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showClass(string $id)
    {
        $class = student_class::with(['student', 'student.User', 'school'])->find($id);
        return response()->json($class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->name;
        $class = student_class::find($id);
        if ($class) {
            $class->update([
                "name" => $name
            ]);
            return response()->json([
                "message" => "name class succesfully updated",
                "data" => $class
            ]);
        } else {
            return response()->json([
                "message" => "class not found",
                "data" => "null"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteClass(string $id)
    {
        $class = student_class::find($id);
        if ($class) {
            $class->delete();
            return response()->json([
                "message" => "class  succesfully deleted",
                "data" => $class
            ]);
        } else {
            return response()->json([
                "message" => "class not found",
                "data" => null
            ], 400);
        }
    }
}
