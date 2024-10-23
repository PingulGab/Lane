@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Memorandum of Agreement</h1>

        <iframe src="{{ asset('storage/AUF-ProposalForm-' . str_replace(' ', '-', $proposal->institution_name) . '-' . $proposal->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

        <a href="{{ route('downloadProposal', ['id' => $proposal->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
        <a href="{{ route('downloadProposal', ['id' => $proposal->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>

        <a href="{{ route('editProposal', ['id' => $proposal->id]) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
