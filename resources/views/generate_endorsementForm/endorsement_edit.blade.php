@php

@endphp

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Edit Endorsement</h1>

        <!-- Form to update the memorandum -->
        <form action="{{ route('updateEndorsement', ['id' => $endorsement->id]) }}" method="POST">
            @csrf

            <!-- Partner Name -->
            <div class="form-group">
                <label for="Description_1">Partner Name</label>
                <input type="text" class="form-control" id="Description_1" name="Description_1" value="{{ $endorsement->Description_1 }}" required>
            </div>

            <div class="form-group">
                <label for="Description_2">Partner Name</label>
                <input type="text" class="form-control" id="Description_2" name="Description_2" value="{{ $endorsement->Description_2 }}" required>
            </div>

            <!-- Save Button -->
            <button type="submit" class="btn btn-success mt-4">Save Changes</button>
        </form>
    </div>
@endsection
