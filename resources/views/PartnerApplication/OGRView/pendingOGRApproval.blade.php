@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

<h2>Document Details</h2>

    <h3>Memorandum</h3>
    @if($document->memorandum)
        <p><strong>Partner Name:</strong> {{ $document->memorandum->partner_name }}</p>
        <p><strong>Contact Person:</strong> {{ $document->memorandum->contact_person }}</p>
        <p><strong>Contact Email:</strong> {{ $document->memorandum->contact_email }}</p>
        <pre>{{ json_encode($document->memorandum->whereas_clauses, JSON_PRETTY_PRINT) }}</pre>
        <pre>{{ json_encode($document->memorandum->articles, JSON_PRETTY_PRINT) }}</pre>
    @else
        <p>No memorandum attached.</p>
    @endif

    <h3>Proposal Form</h3>
    <p>{{ $document->proposalForm->description ?? 'No proposal form linked.' }}</p>

    <h3>Endorsement Form</h3>
    <p>{{ $document->endorsementForm->description_1 ?? 'No endorsement form linked.' }}</p>

    <form action="{{ route('showDocument', ['id' => $id, 'name' => $document->memorandum->partner_name]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Approve</button>
    </form>    

@endsection