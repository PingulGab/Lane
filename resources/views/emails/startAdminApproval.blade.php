<h1>Your Approval Awaits!</h1>

<p>A new form has been submitted.</p>
<p><strong>Link Name:</strong> {{ $document->id }}</p>
<p><strong>Link URL:</strong> <a href="{{ url('/documents/' . $document->id . '/' . $document->memorandum->partner_name) }}"> {{ url('/documents/' . $document->id . '/' . $document->memorandum->partner_name) }} </a></p>

<p>Please log in to view the full submission details.</p>