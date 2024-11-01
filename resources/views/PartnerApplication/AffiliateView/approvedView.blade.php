@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

<h1> Affiliate View - Approving </h1>
<div class="container">
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->memorandum->partner_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    <!--- TODO
    <a href="{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
    <a href="{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>

    <a href="{{ route('editMemorandum', ['id' => $document->memorandum->id]) }}" class="btn btn-warning">Edit</a>
    --->
</div>
@endsection