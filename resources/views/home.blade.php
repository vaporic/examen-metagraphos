@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Sistema de notas</h1>
                @if (Auth::guest())
                    <a class="btn btn-primary" href="{{ url('/auth/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar Sesión</a>
                @else
                    <a class="btn btn-primary" href="{{ url('/notes') }}">Ver Notas</a>
                @endif
            </div>
        </div>
    </div>
@endsection