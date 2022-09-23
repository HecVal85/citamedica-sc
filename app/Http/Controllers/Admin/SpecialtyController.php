<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{


    public function index() {
        $specialties = Specialty::all();
        return view('specialties.index', compact('specialties'));
    }

    public function create() {
        return view('specialties.create');
    }

    public function sendData(Request $request) {
        $rules = [
            'name' => 'required|min:5',
        ];

        $messages = [
            'name.required' => 'El nombe de la especialidad es obligatoria!!',
            'name.min' => 'El nombre de la especialidad debe tener más de 5 carácteres'
        ];

        $this->validate($request, $rules, $messages);

        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'La Especialidad se ha creado correctamente.';

        return redirect('/especialidades')->with(compact('notification'));
    }

    public function edit(Specialty $specialty) {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty) {
        $rules = [
            'name' => 'required|min:5',
        ];

        $messages = [
            'name.required' => 'El nombe de la especialidad es obligatoria!!',
            'name.min' => 'El nombre de la especialidad debe tener más de 5 carácteres'
        ];

        $this->validate($request, $rules, $messages);

        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();

        $notification = 'La Especialidad se ha actualizado correctamente.';

        return redirect('/especialidades')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty) {
        $deleteName = $specialty->name;

        $specialty->delete();

        $notification = 'La Especialidad '. $deleteName .' se ha eliminado correctamente.';

        return redirect('/especialidades')->with(compact('notification'));
    }
}
