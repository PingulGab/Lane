@extends('layouts.layout')

@section('content')
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->memorandum->partner_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    @if (!$isDownloaded)
        <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'docx']) }}')" class="btn btn-primary">Download as .docx</a>
        <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}')" class="btn btn-primary">Download as .pdf</a>
    @else
        <!-- Display any success or error messages -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Upload form for appending document -->
        <form action="{{ route('appendDocument', ['id' => $document->memorandum->id, 'name' => $document->memorandum->partner_name]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- File input for PDF/DOCX file upload -->
            <div class="form-group">
                <label for="document">Upload PDF or DOCX File</label>
                <input type="file" name="document" id="document" class="form-control" accept=".pdf, .docx" required>
                @error('document')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit button to upload and append the document -->
            <button type="submit" class="btn btn-primary mt-3">Append Document</button>
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
