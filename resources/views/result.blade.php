@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

    <h2>Memorandum Details</h2>
    <p>Partner Name: {{ $memorandum->partner_name }}</p>

    <h2>Proposal Form</h2>
    <p>Country: {{ $proposalForm->country }}</p>
    <p>Institution Name: {{ $proposalForm->institution_name }}</p>

    <h2>Endorsement Form</h2>
    <p>Description 1: {{ $endorsementForm->description_1 }}</p>
    <p>Description 2: {{ $endorsementForm->description_2 }}</p>

@endsection
