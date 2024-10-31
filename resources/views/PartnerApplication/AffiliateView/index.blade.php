@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

<h1> Memorandum History </h1>
@foreach($memorandumVersion->versions as $version)
    <div>
        <h4> Version {{ $version->version}} </h4>
        <p>Edited by: {{ $version->editor->name }} on {{ $version->created_at }}</p>
        
        <!-- Show whereas_clauses and articles content -->
        <pre>{{ json_encode($version->whereas_clauses, JSON_PRETTY_PRINT) }}</pre>
        <pre>{{ json_encode($version->articles, JSON_PRETTY_PRINT) }}</pre>

    </div>
@endforeach

<h1> Affiliate View - Approving </h1>
<div class="container">
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->memorandum->partner_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    <form action="{{ route('affiliateApproveDocument', ['id' => $id, 'name' => $document->memorandum->partner_name]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Approve</button>
    </form>

    <!--- TODO
    <a href="{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
    <a href="{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>
    --->

    <a href="{{ route('editMemorandum', ['id' => $document->memorandum->id]) }}" class="btn btn-warning">Edit</a>
</div>
@endsection