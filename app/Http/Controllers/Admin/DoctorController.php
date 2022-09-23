<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', compact('specialties'));
    }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|min:10',
            'email' => 'required|email',
            'cedula' => 'nullable|digits:7',
            'address' => 'nullable|min:10',
            'phone' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre del médico es Obligatorio.',
            'name.min' => 'Debe tener al menos 10 caracteres.',
            'email.required' => 'El campo Correo es obligatorio.',
            'email.min' => 'Debe ser un correo válido.',
            'cedula.digits' => 'Debe tener al menos 7 dígitos.',
            'address' => 'Debe tener al menos 10 caracteres.',
            'phone' => 'El campo Teléfono es obligatorio.',
        ];
        $this->validate($request, $rules, $messages);

        $user = User::create(
            $request->only('name', 'email', 'cedula', 'address', 'phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $user->specialties()->attach($request->input('specialties'));
        $notification = 'El Médico se ha resgistrado correctamente';
        return redirect('/medicos')->with(compact('notification'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);

        $specialties = Specialty::all();
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');

        return view('doctors.edit', compact('doctor', 'specialties', 'specialty_ids'));

    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:10',
            'email' => 'required|email',
            'cedula' => 'nullable|digits:7',
            'address' => 'nullable|min:10',
            'phone' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre del médico es Obligatorio.',
            'name.min' => 'El nombre debe tener al menos 10 caracteres.',
            'email.required' => 'El campo Correo es obligatorio.',
            'email.min' => 'El campo correo debe ser un correo válido.',
            'cedula.digits' => 'El campo cédula debe tener al menos 7 dígitos.',
            'address' => 'El campo dirección debe tener al menos 10 caracteres.',
            'phone' => 'El campo Teléfono es obligatorio.',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::doctors()->findOrFail($id);

        $data = $request->only('name', 'email', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
        $user->specialties()->sync($request->input('specialties'));

        $notification = 'La información del médico se ha actualizado correctamente.';
        return redirect('/medicos')->with(compact('notification'));
    }

    public function destroy($id)
    {
        $user = User::doctors()->findOrFail($id);
        $doctorName = $user->name;
        $user->delete();

        $notification = "La información del médico $doctorName se ha Eliminado correctamente.";

        return redirect('/medicos')->with(compact('notification'));
    }
}
