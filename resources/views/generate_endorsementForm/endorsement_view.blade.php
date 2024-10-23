@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Memorandum of Agreement</h1>

        <iframe src="{{ asset('storage/AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->Description_1) . '-' . $endorsement->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

        <a href="{{ route('downloadEndorsement', ['id' => $endorsement->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
        <a href="{{ route('downloadEndorsement', ['id' => $endorsement->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>

        <a href="{{ route('editEndorsement', ['id' => $endorsement->id]) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
