@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0"> Cancelar citas </h3>
                </div>
            </div>
            <div class="col text-right">
                <a href="{{ url('/miscitas') }} " class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-circle-left"></i>
                    Regresar </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('notification'))
                <div class="alert alert-success" role="alert">
                    {{ session('notification') }}
                </div>
            @endif
            @if ($role == 'paciente')
                <p> Se cancelará tu cita reservada con el médico <b> {{ $appointment->doctor->name }} </b> (especialidad <b> {{ $appointment->specialty->name}} </b>)
                    para el día <b> {{ $appointment->scheduled_date}} </b>. </p>
            @elseif ($role == 'doctor')
                <p> Se cancelará la cita del paciente <b> {{ $appointment->patient->name }}
                </b> (especialidad <b> {{ $appointment->specialty->name}} </b>)
                    para el día <b> {{ $appointment->scheduled_date}} </b>,
                    la hora <b> {{ $appointment->scheduled_time_12 }} </b> </p>
            @elseif ($role == 'admin')
                <p> Se cancelará la cita del paciente <b> {{ $appointment->patient->name }} </b>
                    (especialidad <b> {{ $appointment->specialty->name}} </b>)
                    que será antendido por el doctor: <b> {{ $appointment->doctor->name }} </b>
                    para el día: <b> {{ $appointment->scheduled_date}} </b>,
                    a la hora: <b> {{ $appointment->scheduled_time_12 }} </b>
                </p>
            @endif


            <form action="{{ url('/miscitas/'.$appointment->id.'/cancel') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="justification"> Escriba el motivo de la cancelación: </label>
                    <textarea name="justification" id="justification" rows="3" class="form-control" required></textarea>
                </div>

                <button class="btn btn-danger" type="submit"> Cancelar cita </button>
            </form>

        </div>

    </div>
@endsection
