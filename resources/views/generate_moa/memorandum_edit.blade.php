@php
    $whereasClauses = is_string($memorandum->whereas_clauses) ? json_decode($memorandum->whereas_clauses, true) : $memorandum->whereas_clauses;
    $article_1 = is_string($memorandum->article_1) ? json_decode($memorandum->article_1, true) : $memorandum->article_1;

    if (is_array($whereasClauses)) {
        foreach ($whereasClauses as $index => $clause) {
            if (is_array($clause)) {
                // Convert nested arrays to string (customize this as needed for your specific structure)
                $whereasClauses[$index] = implode(', ', $clause);
            }
        }
    }

    if (is_array($article_1)) {
        foreach ($article_1 as $index => $article) {
            if (is_array($article)) {
                // Convert nested arrays to string (customize this as needed for your specific structure)
                $articles[$index] = implode(', ', $article);
            }
        }
    }
@endphp

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Edit Memorandum of Agreement</h1>

        <!-- Form to update the memorandum -->
        <form action="{{ route('updateMemorandum', ['id' => $memorandum->id]) }}" method="POST">
            @csrf

            <!-- Partner Name -->
            <div class="form-group">
                <label for="partner_name">Partner Name</label>
                <input type="text" class="form-control" id="partner_name" name="partner_name" value="{{ $memorandum->partner_name }}" required>
            </div>

            <div class="form-group">
                <label for="contact_person">Contact contact_person Person</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ $memorandum->contact_person }}" required>
            </div>

            <div class="form-group">
                <label for="contact_email">Contact Person Email Address</label>
                <input type="text" class="form-control" id="contact_email" name="contact_email" value="{{ $memorandum->contact_email }}" required>
            </div>

            <!-- Whereas Clauses -->
            <div id="whereas-clauses" class="form-group">
                <label>Whereas Clauses</label>
                @foreach($whereasClauses as $index => $clause)
                    <div class="clause-group mt-2">
                        <textarea class="form-control" name="whereas_clauses[]" required>{{ $clause }}</textarea>
                        <button type="button" class="btn btn-danger remove-clause mt-2">Remove</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-whereas" class="btn btn-secondary mt-3">Add Whereas Clause</button>

            <!-- Article Clauses -->
            <div id="article-3" class="form-group">
                <label>Article 3 Clauses</label>
                @foreach($article_1 as $index => $article)
                    <div class="article-group mt-2">
                        <textarea class="form-control" name="articles[]" required>{{ $article }}</textarea>
                        <button type="button" class="btn btn-danger remove-article mt-2">Remove</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-article" class="btn btn-secondary mt-3">Add Article 3.x</button>

            <!-- Save Button -->
            <button type="submit" class="btn btn-success mt-4">Save Changes</button>
        </form>
    </div>

    <script>
        // Function to attach remove event to new and existing remove buttons
        function attachRemoveEvent() {
            document.querySelectorAll('.remove-clause').forEach(function(button) {
                button.onclick = function() {
                    this.parentElement.remove();
                };
            });

            document.querySelectorAll('.remove-article').forEach(function(button) {
                button.onclick = function() {
                    this.parentElement.remove();
                };
            });
        }

        // Initially attach the remove event to existing buttons
        attachRemoveEvent();

        // Add new "whereas" clause
        document.getElementById('add-whereas').addEventListener('click', function() {
            const container = document.getElementById('whereas-clauses');
            const newClauseDiv = document.createElement('div');
            newClauseDiv.classList.add('clause-group', 'mt-2');
            newClauseDiv.innerHTML = `
                <textarea class="form-control" name="whereas_clauses[]" required></textarea>
                <button type="button" class="btn btn-danger remove-clause mt-2">Remove</button>
            `;
            container.appendChild(newClauseDiv);
            attachRemoveEvent(); // Re-attach the remove event to the new clause
        });

        // Add new "article" clause
        document.getElementById('add-article').addEventListener('click', function() {
            const container = document.getElementById('article-3');
            const newArticleDiv = document.createElement('div');
            newArticleDiv.classList.add('article-group', 'mt-2');
            newArticleDiv.innerHTML = `
                <textarea class="form-control" name="articles[]" required></textarea>
                <button type="button" class="btn btn-danger remove-article mt-2">Remove</button>
            `;
            container.appendChild(newArticleDiv);
            attachRemoveEvent(); // Re-attach the remove event to the new article
        });
    </script>
@endsection
