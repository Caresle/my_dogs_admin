<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\DogType;
use Illuminate\Http\Request;

class DogsTypeController extends Controller
{
    public function index(Request $request) {
        $dogs_types = DogType::all();

        return inertia('DogsType/DogsType', [
            'dogsType' => $dogs_types,
        ]);
    }

    public function create() {
        return inertia('DogsType/DogsTypeForm');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|min:5|max:255|unique:dog_types,name',
        ]);

        DogType::create([
            'name' => $request->name,
        ]);

        return to_route('dogs_type.index');
    }

    public function edit(string $id) {
        $dog_type = DogType::find($id);
        dd($dog_type);
    }

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {
        $valid = Dog::where('id_dog_type', '=', $id)->count();

        if ($valid >= 1)
            return back()->withErrors(['general' => "You can't delete a dog type that is being in use"]);

        DogType::find($id)->delete();

        return to_route('dogs_type.index');
    }
}
