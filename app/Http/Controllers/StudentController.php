<?php

namespace App\Http\Controllers;

use App\Models\student_class;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\student;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAll()
    {
        $student = student::with(['User', 'city', 'school', 'class'])->get();
        return response()->json($student);
    }


    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:student_classes,id',
        ]);

        try {
            // Buat User terlebih dahulu
            $user = User::create([
                'name' => $validated['name'],
                'email' => strtolower(str_replace(' ', '.', $validated['name'])) . '@example.com',
                'password' => bcrypt('default_password'),
            ]);

            // Buat Student setelah User berhasil dibuat
            $student = Student::create([
                'user_id' => $user->id,
                'city_id' => $validated['city_id'],
                'school_id' => $validated['school_id'],
                'class_id' => $validated['class_id'],
            ]);

            return response()->json([
                'message' => "Student {$validated['name']} successfully created",
                'data' => $student,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function showStudent(string $id)
    {
        try {
            $student = student::with(['User', 'city', 'school', 'class'])->find($id);
            return response()->json([
                $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => "Failed to find student",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $student = student::find($id);
            $student->update([
                'name' => $request->name,
                'city_id' => $request->city_id,
                'school_id' => $request->school_id,
                'class_id' => $request->class_id
            ]);
            $user = $student->User;
            $user->update([
                'name' => $request->name
            ]);


            return response()->json([
                "message" => "student with name $user->name succesfully updated",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => "student failed to updated",
                "error" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $user = User::with('student')->find($id);
        if ($user) {
            $user->delete();

            return response()->json([
                "message" => "student $user->name succesfully deleted",
                "data" => $user
            ]);
        } else {
            return response()->json([
                "message" => "failed to find student",
                "error" => null
            ]);
        }
    }
}
