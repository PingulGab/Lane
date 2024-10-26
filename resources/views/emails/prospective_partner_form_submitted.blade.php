<!-- resources/views/emails/form_submitted.blade.php -->

<h1>New Prospective Partner Form Submission</h1>

<p>A new form has been submitted.</p>
<p><strong>Link Name:</strong> {{ $link->name }}</p>
<p><strong>Link URL:</strong> <a href="{{ url('/result/' . $link->link) }}">{{ url('/result/' . $link->link) }}</a></p>

<p>Please log in to view the full submission details.</p>
