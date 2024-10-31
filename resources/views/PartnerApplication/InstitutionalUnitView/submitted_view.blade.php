@extends('layouts.layout')

@section('content')

<h2>Memorandum Details</h2>
<p>Partner Name: {{ $memorandum->partner_name }}</p>

<h2>Proposal Form</h2>
<p>Country: {{ $proposalForm->country }}</p>
<p>Institution Name: {{ $proposalForm->institution_name }}</p>

<!--- View #1 --->

<div class="container">
    <h1> View #1: </h1>

    <!-- PDF Viewer Container -->
    <div id="pdf-viewer" style="width: 100%; height: 300px;"></div>

    <!-- Pagination Controls -->
    <div style="text-align: center; margin-top: 10px;">
        <button id="prev-page">Previous Page</button>
        <span>Page: <span id="page-num">1</span> / <span id="page-count">1</span></span>
        <button id="next-page">Next Page</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var pdfUrl = "{{ asset('storage/endorsement-form/AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->description_1) . '-' . $endorsement->created_at->format('Ymd') . '.pdf') }}";
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        let pdfDoc = null;
        let pageNum = 1;
        let pageRendering = false;
        let pageNumPending = null;
        const scale = 0.8;
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        document.getElementById('pdf-viewer').appendChild(canvas);

        // Load PDF document
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });

        // Render the page
        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                const renderTask = page.render(renderContext);
                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page-num').textContent = num;
        }

        // Queue rendering of next page if a page is already being rendered
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        // Go to previous page
        document.getElementById('prev-page').addEventListener('click', function() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        });

        // Go to next page
        document.getElementById('next-page').addEventListener('click', function() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        });
    });
</script>

<!--- View #2 --->
<!--- <div class="container">
    <h1>View #2</h1>

    <iframe src="{{ asset('storage/endorsement-form/AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->description_1) . '-' . $endorsement->created_at->format('Ymd') . '.pdf') }}" width="100%" height="600px"></iframe>

    <a href="{{ route('downloadEndorsement', ['id' => $endorsement->id, 'format' => 'docx']) }}" class="btn btn-primary">Download as .docx</a>
    <a href="{{ route('downloadEndorsement', ['id' => $endorsement->id, 'format' => 'pdf']) }}" class="btn btn-primary">Download as .pdf</a>

    <a href="{{ route('editEndorsement', ['id' => $endorsement->id]) }}" class="btn btn-warning">Edit</a>
</div> --->

@endsection