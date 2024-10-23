@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Memorandum of Agreement</h1>

        <iframe src="{{ asset('storage/AUF-MOA-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

        <a href="{{ route('downloadMemorandum', ['id' => $memorandum->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
        <a href="{{ route('downloadMemorandum', ['id' => $memorandum->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>

        <a href="{{ route('editMemorandum', ['id' => $memorandum->id]) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
