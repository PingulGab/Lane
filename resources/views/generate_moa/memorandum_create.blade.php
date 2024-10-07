@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Create Memorandum of Agreement</h1>

        <form action="{{ route('generateMemorandum') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="partner_name">Partner Name</label>
                <input type="text" class="form-control" id="partner_name" name="partner_name" required>
            </div>

            <div id="whereas-clauses" class="form-group">
                <label>Whereas Clauses</label>
                <textarea class="form-control" name="whereas_clauses[]" required></textarea>
            </div>
            <button type="button" id="add-whereas" class="btn btn-secondary">Add Whereas Clause</button>

            <div id="article-3" class="form-group">
                <label>Article 3 Clauses</label>
                <textarea class="form-control" name="articles[]" required></textarea>
            </div>
            <button type="button" id="add-article" class="btn btn-secondary">Add Article 3.x</button>

            <button type="submit" class="btn btn-success mt-3">Generate MOA</button>
        </form>

        <script>
            document.getElementById('add-whereas').addEventListener('click', function() {
                const container = document.getElementById('whereas-clauses');
                const newClause = document.createElement('textarea');
                newClause.classList.add('form-control', 'mt-2');
                newClause.name = 'whereas_clauses[]';
                newClause.required = true;
                container.appendChild(newClause);
            });

            document.getElementById('add-article').addEventListener('click', function() {
                const container = document.getElementById('article-3');
                const newArticle = document.createElement('textarea');
                newArticle.classList.add('form-control', 'mt-2');
                newArticle.name = 'articles[]';
                newArticle.required = true;
                container.appendChild(newArticle);
            });
        </script>
    </div>
@endsection
