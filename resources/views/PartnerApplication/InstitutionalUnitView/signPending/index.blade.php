@extends('layouts.layout')

@section('content')
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->memorandum->partner_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    @if (!$isDownloaded)
        <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'docx']) }}')" class="btn btn-primary">Download as .docx</a>
        <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}')" class="btn btn-primary">Download as .pdf</a>
    @else
        <!-- Show Upload Button if already downloaded -->
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="signed_document" required>
            <button type="submit" class="btn btn-success">Upload Signed Document</button>
        </form>
    @endif

    <script>
        function downloadDocument(url) {
            // Create a hidden link element
            var link = document.createElement('a');
            link.href = url;
            link.download = '';

            // Append to the body
            document.body.appendChild(link);

            // Programmatically click the link to trigger the download
            link.click();

            // Remove the link from the document
            document.body.removeChild(link);

            // Refresh the page
            location.reload();
        }
    </script>
@endsection
