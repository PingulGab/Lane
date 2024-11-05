@extends('layouts.nonAdmin')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style>
    .previewStyle {
        font-family: 'Times New Roman', serif;
        font-size: 18px;
        width: 70vh;
        height: 70vh;
        overflow: auto;
        text-align: justify;
        background-color: white;
        padding: 30px;
        border-radius: 15px;
    }

    .biContainer {
        display: flex;
    }

    .biContainer-area1 {
        flex: 1;
    }

    .biContainer-area2 {
        flex: 1;
    }
</style>
<div class="biContainer">
    <div class="biContainer-area1">
        <div class="previewStyle">
            @include('components.documents_preview.moa')
        </div>
        <div id="dropdown-container">
            <select id="page-selector" onchange="navigateToPage()">
                <option value="page1">Title Page</option>
                <option value="page2">Introduction</option>
                <option value="page3">Article 1: Program Overview</option>
                <option value="page4">Article 2: Representation and Warranties</option>
                <option value="page5">Article 3: Scope of Collaboration</option>
                <option value="page6">Article 4: Responsibilities of AUF</option>
                <option value="page7">Article 5: Responsibilities of {{ $document->proposalForm->institution_name_acronym }}</option>
                <option value="page8">Article 6: Responsibilities of AUF and {{ $document->proposalForm->institution_name_acronym }}</option>
                <option value="page9">Article 7: Intellectual Property Rights</option>
                <option value="page10">Article 8: Employment Relations</option>
                <option value="page11">Article 9: Exclusivity</option>
                <option value="page12">Article 10: Material Adverse Change Clause</option>
                <option value="page13">Article 11: Confidentiality</option>
                <option value="page14">Article 12: Compliance with Law</option>
                <option value="page15">Article 13: Non-Assignment of Rights</option>
                <option value="page16">Article 14: Severability</option>
                <option value="page17">Article 15: Effectivity</option>
                <option value="page18">Article 16: Amendments</option>
                <option value="page19">Article 17: Governing Law</option>
                <option value="page20">Article 18: Dispute Resolution</option>
                <option value="page21">Article 19: Venue of Action</option>
                <option value="page22">Article 20: Notices</option>
                <option value="page23">Article 21: Subsequent Agreements</option>
            </select>
        </div>
    </div>
    <div class="biContainer-area2">

    </div>
</div>
    @if (!$isDownloaded)
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
                <form id="uploadForm" action="{{ route('appendDocument', ['id' => $document->id, 'name' => $document->proposalForm->institution_name]) }}" method="POST" enctype="multipart/form-data">
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
                    <div>
                        <label for="sign_location">Location of Signing</label>
                        <input type="input" id="sign_location" name="sign_location" required>
                    </div>

                    <button type="submit">Submit Document</button>
                </form>
            </div>
        </div>

        <script>
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
        </script>
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
