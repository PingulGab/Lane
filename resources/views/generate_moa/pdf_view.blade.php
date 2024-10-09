<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOA PDF</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            text-align: justify;
            margin-left: 120px;  /* Equivalent to 1.25 inches */
            margin-right: 120px; /* Equivalent to 1.25 inches */
            margin-top: 96px;    /* Equivalent to 1 inch */
            margin-bottom: 96px; /* Equivalent to 1 inch */
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
        .leading-paragraph {
            text-align: justify;
            margin-bottom: 15px;
        }
        .indented-paragraph {
            text-indent: 40px;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .text-center {
            text-align: center;
        }
        h1, h2 {
            text-align: center;
            font-weight: bold;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- First Page --}}
    <br> <br> <br>
    <h1>ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)</h1>
    <h1>AND</h1>
    <h1>{{ strtoupper($partner_name) }}</h1>

    <br><br>

    <h1>MEMORANDUM OF AGREEMENT FOR {Reason}</h1>
    <div style="page-break-after: always;"></div>
    {{-- Memorandum of Agreement Section --}}
    <h2>MEMORANDUM OF AGREEMENT</h2>
    <br>
    <p class="leading-paragraph">KNOW ALL MEN BY THESE PRESENTS:</p>
    <p class="indented-paragraph">
        This Memorandum of Agreement ("Agreement") is executed on {Date}, in Angeles City, Philippines, by and between:
    </p>

    <br>

    <p class="indented-paragraph bold">
        ANGELES UNIVERSITY FOUNDATION (PHILIPPINES),
    </p>
    <p class="indented-paragraph">
        a higher education institution duly organized and existing under the laws of the Republic of the Philippines, with principal address at MacArthur Highway, Angeles City, Philippines, duly represented herein by its President, 
        <span class="bold">DR. JOSEPH EMMANUEL L. ANGELES </span>(hereafter referred to as <span class="bold">"AUF"</span>).
    </p>

    <br>

    <p class="text-center">and</p>

    <br>

    <p class="indented-paragraph">
        <span class="bold"> {{ strtoupper($partner_name) }} </span>, a time-honored and well-acclaimed institution of higher learning duly organized and existing under the laws of the People’s Republic of China, with principal address at No.1 Keji Road, Shangjie, Minhou, Fuzhou, Fujian, People’s Republic of China, herein represented by its President, 
        <span class="bold">{{ strtoupper($contact_person) }}</span> (hereafter referred to as <span class="bold">"{PartnerName_Abbreviation}"</span>).
    </p>

    {{-- Witnesseth That Section --}}
    <h2>WITNESSETH THAT:</h2>
        @foreach($whereasClauses as $index => $clause)
            {{ $clause }} <br>
        @endforeach

    

    <br>

    {{-- Add articles if needed --}}
    <h2>Article 3: Scope of Collaboration</h2>
    @if (!empty($articles))
        @foreach($articles as $index => $article)
            <p class="indented-paragraph">3.{{ $index + 1 }} {{ $article }}</p>
        @endforeach
    @endif

</body>
</html>
