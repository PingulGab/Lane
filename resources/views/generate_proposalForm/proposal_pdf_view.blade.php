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
    <h1> Institution Name: {{ $institution_name }}</h1>
    <h1> Country: {{ $country }} </h1>

</body>
</html>
