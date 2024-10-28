@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

<h2>Enter Password to Access the Content</h2>

<!-- Check for validation errors -->
@if ($errors->any())
    <div>
        <strong>{{ $errors->first('password') }}</strong>
    </div>
@endif

<form method="POST" action="{{ route('validatePasswordSubmittedForm', $link->link) }}">
    @csrf
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Submit</button>
</form>

@endsection