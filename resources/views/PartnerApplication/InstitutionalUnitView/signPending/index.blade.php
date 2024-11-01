@extends('layouts.layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <iframe src="{{ asset('storage/memorandum/AUF-Memorandum-' . str_replace(' ', '-', $document->memorandum->partner_name) . '-' . $document->memorandum->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    @if (!$isDownloaded)
        <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'docx']) }}')" class="btn btn-primary">Download as .docx</a>
        <a href="#" onclick="downloadDocument('{{ route('downloadMemorandum', ['id' => $document->memorandum->id, 'format' => 'pdf']) }}')" class="btn btn-primary">Download as .pdf</a>
    @elseif ($isDownloaded && !$document->is_signed)
        <!-- Display any success or error messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div>
            <h2>Append Document</h2>
            <form id="appendDocumentForm">
                @csrf
                <!-- Button to open the modal -->
                <button type="button" id="openModalButton">Upload Document</button>
            </form>
        </div>
    
        <!-- Modal for document upload and additional questions -->
        <div id="documentModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Upload Document</h2>
    
                <!-- Modal form for additional questions and file upload -->
                <form id="uploadForm" action="{{ route('appendDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="document">Choose File</label>
                        <input type="file" id="document" name="document" required accept=".pdf">
                    </div>
                    
                    <!-- Additional questions -->
                    <div>
                        <label for="date_of_signing">Date of Signing</label>
                        <input type="date" id="date_of_signing" name="date_of_signing" required>
                    </div>
                    <div>
                        <label for="valid_until">Valid Until</label>
                        <input type="date" id="valid_until" name="valid_until" required>
                    </div>
    
                    <h3>International Partnership Questions</h3>
                    <div>
                        <label for="intl_students_outbound">AUF students (outbound)</label>
                        <input type="number" id="intl_students_outbound" name="intl_students_outbound" min="0">
                    </div>
                    <div>
                        <label for="intl_students_inbound">Foreign students (inbound)</label>
                        <input type="number" id="intl_students_inbound" name="intl_students_inbound" min="0">
                    </div>
                    <div>
                        <label for="intl_faculty_outbound">AUF faculty (outbound)</label>
                        <input type="number" id="intl_faculty_outbound" name="intl_faculty_outbound" min="0">
                    </div>
                    <div>
                        <label for="intl_faculty_inbound">Foreign faculty (inbound)</label>
                        <input type="number" id="intl_faculty_inbound" name="intl_faculty_inbound" min="0">
                    </div>
    
                    <h3>Local Partnership Questions</h3>
                    <div>
                        <label for="local_students_auf">AUF students participated</label>
                        <input type="number" id="local_students_auf" name="local_students_auf" min="0">
                    </div>
                    <div>
                        <label for="local_students_other">Other HEIs students participated</label>
                        <input type="number" id="local_students_other" name="local_students_other" min="0">
                    </div>
                    <div>
                        <label for="local_faculty_auf">AUF faculty participated</label>
                        <input type="number" id="local_faculty_auf" name="local_faculty_auf" min="0">
                    </div>
                    <div>
                        <label for="local_faculty_other">Other HEIs faculty participated</label>
                        <input type="number" id="local_faculty_other" name="local_faculty_other" min="0">
                    </div>
    
                    <button type="submit">Submit Document</button>
                </form>
            </div>
        </div>
    @elseif($document->is_signed)

        <div>
            <h1> Already Signed </h1>
        </div>

    @endif
    <style>
        /* Modal styles */
        .modal {
          display: none;
          position: fixed;
          z-index: 1;
          padding-top: 100px;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
          background-color: #fefefe;
          margin: auto;
          padding: 20px;
          border: 1px solid #888;
          width: 80%;
          max-width: 500px;
          text-align: center;
          border-radius: 8px;
        }
        
        .close {
          color: #aaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
          cursor: pointer;
        }
        
        .close:hover,
        .close:focus {
          color: black;
        }
    </style>
    <script>
    // CSRF token
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modal elements
    var modal = document.getElementById('documentModal');
    var openModalBtn = document.getElementById('openModalButton');
    var closeModalBtn = document.getElementsByClassName('close')[0];

    // Show modal on button click
    openModalBtn.onclick = function() {
        modal.style.display = "block";
    }

    // Close modal on 'x' click
    closeModalBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

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
