<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:10',
            'email' => 'required|email',
            'cedula' => 'nullable|digits:7',
            'address' => 'nullable|min:10',
            'phone' => 'nullable'
        ];
        $messages = [
            'name.required' => 'El nombre del paciente es Obligatorio.',
            'name.min' => 'El nombre del paciente debe tener al menos 10 caracteres.',
            'email.required' => 'El campo Correo es obligatorio.',
            'email.min' => 'Debe ser un correo válido.',
            'cedula.digits' => 'La cédiula debe tener al menos 7 dígitos.',
            'address' => 'La dirección debe tener al menos 10 caracteres.',
        ];
        $this->validate($request, $rules, $messages);

        User::create(
            $request->only('name', 'email', 'address', 'phone')
            + [
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $notification = 'El paciente se ha resgistrado correctamente';
        return redirect('/pacientes')->with(compact('notification'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $patient = User::Patients()->findOrFail($id);
        return view('patients.edit', compact('patient'));
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
            'name.required' => 'El nombre del paciente es Obligatorio.',
            'name.min' => 'El nombre del paciente debe tener al menos 10 caracteres.',
            'email.required' => 'El campo Correo es obligatorio.',
            'email.min' => 'El campo correo debe ser un correo válido.',
            'cedula.digits' => 'El campo cédula debe tener al menos 7 dígitos.',
            'address' => 'El campo dirección debe tener al menos 10 caracteres.',
            'phone' => 'El campo Teléfono es obligatorio.',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::Patients()->findOrFail($id);

        $data = $request->only('name', 'email', 'cedula', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();

        $notification = 'La información del paciente se ha actualizado correctamente.';
        return redirect('/pacientes')->with(compact('notification'));
    }

    public function destroy($id)
    {
        $user = User::Patients()->findOrFail($id);
        $PacienteName = $user->name;
        $user->delete();

        $notification = "La información del paciente $PacienteName se ha Eliminado correctamente.";

        return redirect('/pacientes')->with(compact('notification'));
    }
}
