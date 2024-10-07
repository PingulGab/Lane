<!DOCTYPE html>
<html>
<head>
    <title>Memorandum of Agreement</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            text-align: justify;
        }
        h1 {
            text-align: center;
            font-size: 16pt;
        }
        h2 {
            font-size: 14pt;
            margin-top: 20px;
        }
        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Memorandum of Agreement</h1>

    <p>This Memorandum of Agreement is made by and bezzztween:</p>
    <p><strong>{{ $partner_name }}</strong></p>

    <h2>Whereas Clauses</h2>
    @foreach($whereasClauses as $index => $clause)
        <p>{{ $index + 1 }}. {{ $clause }}</p>
    @endforeach

    <h2>Article 3: Scope of Collaboration</h2>
    @foreach($articles as $index => $article)
        <p>3.{{ $index + 1 }} {{ $article }}</p>
    @endforeach
</body>
</html>
