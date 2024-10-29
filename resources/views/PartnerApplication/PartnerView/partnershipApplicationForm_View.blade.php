@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

    <form method="POST" action="{{route('submitProspectPartnerForm', $link->link)}}">
        @csrf

        <h3>Select College</h3>
        @foreach($collegesList as $college)
            <div>
                <input 
                    type="checkbox" 
                    name="selected_colleges[]" 
                    value="{{ $college->id }}" 
                    id="college_{{ $college->id }}"
                >
                <label for="college_{{ $college->id }}">{{ $college->name }}</label>
            </div>
        @endforeach

        <h3>Select Affiliate</h3>
        @foreach($affiliateList as $affiliate)
            <div>
                <input 
                    type="checkbox" 
                    name="selected_affiliates[]" 
                    value="{{ $affiliate->id }}" 
                    id="affiliate_{{ $affiliate->id }}"
                >
                <label for="affiliate_{{ $affiliate->id }}">{{ $affiliate->name }}</label>
            </div>
        @endforeach

        <input type="text" name="partner_name" placeholder="Partner Name">
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="institution_name" placeholder="Institution Name">
        <button type="submit">Submit</button>
    </form>

@endsection
