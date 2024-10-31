@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')
<h1> Affiliate View - Approving </h1>
<div class="container">
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->memorandum->partner_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    <form action="{{ route('affiliateApproveDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Approve</button>
    </form>

    <!--- TODO
    <a href="{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
    <a href="{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>
    --->

    <a href="{{ route('editMemorandum', ['id' => $document->memorandum->id]) }}" class="btn btn-warning">Edit</a>

    <h3>Version History</h3>
    <ul>
        @foreach($document->memorandum->versions as $version)
            <li>
                <a href="{{ route('displayMemorandumComparison', ['id' => $document->id, 'version' => $version->version]) }}" class="btn btn-primary"> Version {{ $version->version }} </a>
                (Edited by: {{ $version->editor->name ?? 'Unknown' }})
            </li>
        @endforeach

        <li>
            <a href="{{ route('displayMemorandumComparison', ['id' => $document->id, 'version' => $document->memorandum->version]) }}" class="btn btn-primary">
                Version {{ $document->memorandum->version }} (Current)
            </a>
            (Edited by: {{ $document->memorandum->editor->name ?? 'Unknown' }})
        </li>
        
    </ul>
</div>
@endsection