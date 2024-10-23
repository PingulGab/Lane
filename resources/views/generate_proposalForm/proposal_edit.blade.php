@php

@endphp

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Edit Proposal Form</h1>

        <!-- Form to update the memorandum -->
        <form action="{{ route('updateProposal', ['id' => $proposal->id]) }}" method="POST">
            @csrf

            <!-- Partner Name -->
            <div class="form-group">
                <label for="institution_name">Partner Name</label>
                <input type="text" class="form-control" id="institution_name" name="institution_name" value="{{ $proposal->institution_name }}" required>
            </div>

            <!-- Country Name -->
            <div class="form-group">
                <label for="country">Country Name</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ $proposal->country }}" required>
            </div>

            <!-- Save Button -->
            <button type="submit" class="btn btn-success mt-4">Save Changes</button>
        </form>
    </div>
@endsection
