@extends('layouts.layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->proposalForm->institution_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>>
    <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}')" class="btn btn-primary">Download as .pdf</a>

    <div class="container">
    
        <form action="{{ route('approveSignedDocument', ['id' => $document->id, 'name' => $document->proposalForm->institution_name]) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Approve</button>
        </form>
    
        <div id="versionHistory">
            <h3>Version History</h3>
            <ul>
                @foreach($document->memorandum->versions as $version)
                    @if($version->version !== '1.0')
                        <li>
                            <a href="{{ route('compareVersion', ['id' => $document->memorandum->id, 'version' => $version->version]) }}" class="btn btn-primary">
                                Version {{ $version->version }}
                            </a>
                            (Edited by: {{ $version->editor->name ?? 'Unknown' }})
                        </li>
                    @endif
                @endforeach
            
                <li>
                    <a href="{{ route('compareVersion', ['id' => $document->memorandum->id, 'version' => $document->memorandum->version]) }}" class="btn btn-primary">
                        Version {{ $document->memorandum->version }} (Last Edit)
                    </a>
                    (Edited by: {{ $document->memorandum->editor->name ?? 'Unknown' }})
                </li>
            </ul>  
        </div>

@endsection
