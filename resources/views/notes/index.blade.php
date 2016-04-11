@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="pull-left">Notes</h1>
        <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('notes.create') !!}">Add New</a>

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        @if($notes->isEmpty())
            <div class="well text-center">No Notes found.</div>
        @else
            @include('notes.table')
        @endif
        
    </div>
@endsection