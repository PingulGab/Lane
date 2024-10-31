@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

    <form method="POST" action="{{route('submitProspectPartnerForm', $link->link)}}">
        @csrf

        <h3>Select Institutional Unit</h3>
        @foreach($institutionalUnitList as $institutionalUnit)
            <div>
                <input 
                    type="checkbox" 
                    name="selected_institutionalUnits[]" 
                    value="{{ $institutionalUnit->id }}" 
                    id="institutionalUnit_{{ $institutionalUnit->id }}"
                >
                <label for="institutionalUnit_{{ $institutionalUnit->id }}">{{ $institutionalUnit->name }}</label>
            </div>
        @endforeach

        <input type="text" name="partner_name" placeholder="Partner Name">
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="institution_name" placeholder="Institution Name">
        <button type="submit">Submit</button>
    </form>

@endsection
