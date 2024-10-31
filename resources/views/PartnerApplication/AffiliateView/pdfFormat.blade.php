<html>
<head>
    <style>
        .added { color: green; }
        .removed { color: red; text-decoration: line-through; }
        .unchanged { color: black; }
    </style>
</head>
<body>
    <h1>Comparison of Memorandum Versions {{$previousVersion}} and {{$currentVersion}}</h1>

    <h2>Whereas Clauses</h2>
    @foreach($whereasDiff as $clause)
        <p>
            @if($clause['status'] === 'removed')
                <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
            @elseif($clause['status'] === 'added')
                <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
            @elseif($clause['status'] === 'changed')
                <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                <br>
                <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
            @elseif($clause['status'] === 'unchanged')
                <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
            @endif
        </p>
    @endforeach

    <h2>Articles</h2>
    @foreach($articlesDiff as $article)
        <p>
            @if($article['status'] === 'removed')
                <span class="removed">{{ is_array($article['content']) ? implode(', ', $article['content']) : $article['content'] }}</span>
            @elseif($article['status'] === 'added')
                <span class="added">{{ is_array($article['content']) ? implode(', ', $article['content']) : $article['content'] }}</span>
            @elseif($article['status'] === 'changed')
                <span class="removed">{{ is_array($article['removed']) ? implode(', ', $article['removed']) : $article['removed'] }}</span>
                <br>
                <span class="added">{{ is_array($article['added']) ? implode(', ', $article['added']) : $article['added'] }}</span>
            @elseif($article['status'] === 'unchanged')
                <span class="unchanged">{{ is_array($article['content']) ? implode(', ', $article['content']) : $article['content'] }}</span>
            @endif
        </p>
    @endforeach
</body>
</html>
