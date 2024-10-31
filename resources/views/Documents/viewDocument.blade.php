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

    <h3>Approval Status</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Affiliate</th>
                <th>Status</th>
                <th>Approved At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($document->approvals as $approval)
                <tr>
                    <td>{{ $approval->affiliate->name }}</td>
                    <td>{{ $approval->is_approved ? 'Approved' : 'Pending' }}</td>
                    <td>{{ $approval->approved_at ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection