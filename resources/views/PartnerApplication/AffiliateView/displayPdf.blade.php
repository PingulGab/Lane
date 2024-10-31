@extends('layouts.layout')

@section('title', 'LANE - Version Comparison')

@section('content')
    <h1>Comparison of Version {{ $selectedVersion }} and {{ $currentVersion }}</h1>
    <div class="container">
        <iframe src="{{ route('compareVersion', ['id' => $id, 'version' => $version]) }}" width="100%" height="800px"></iframe>
    </div>
@endsection
