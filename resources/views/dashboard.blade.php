@extends('app')
@section('title','Dashboard')
@section('content')
    {{ Auth::user()->email }}
@endsection