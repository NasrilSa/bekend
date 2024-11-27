<?php

namespace App\Http\Controllers;

use App\Models\city;
use Illuminate\Http\Request;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAll()
    {
        $city = city::select('id', 'name')->get();
        return response()->json(
            $city
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);

        $city = $request->name;

        $cityExist = city::where('name', $city)->first();
        if ($cityExist) {
            return response()->json([
                "message" => "city  with name $city is already created."
            ]);
        }


        $saveCity = city::create([
            "name" => $city
        ]);
        if ($saveCity) {
            return response()->json([
                "message" => "New city has been created.",
                "data" => $city
            ]);
        } else {
            return response()->json([
                "message" => "data gagal ditambahkan",
                "data" => null
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showCity(string $id)
    {
        $city  = city::with('school')->find($id);
        return response()->json($city);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $city = city::find($id);
        $cityName = $request->name;
        $request->validate([
            "name" => "required"
        ]);
        $cityExist = city::where('name', $cityName)->where('id', '!=', $id)->first();
        if ($cityExist) {
            return response()->json([
                "message" => "city with name $cityName is already created"
            ]);
        }

        if ($city) {

            $city->update([
                'name' => $cityName
            ]);
            return response()->json([
                "message" => "city has been updated",
                "data" => $city
            ]);
        } else {
            return response()->json([
                "message" => "data gagal ditambahkan",
                "data" => null
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteCity(string $id)
    {
        $city = city::find($id);
        if ($city) {
            $city->delete();
            return response()->json([
                "message" => "data berhasil dihapus"
            ]);
        } else {
            return response()->json([
                "message" => "city not found,so not deleted"
            ]);
        }
    }
}
