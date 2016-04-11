@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Notes</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($notes, ['route' => ['notes.update', $notes->id], 'method' => 'patch']) !!}

            @include('notes.fields')

            {!! Form::close() !!}
        </div>
    </div>
@endsection