<?php

$endorsement = $document->endorsementForm;

$path = public_path('images/auf_logo.png'); // Corrected path for the image
$imageData = base64_encode(file_get_contents($path));
$aufLogo = 'data:image/png;base64,' . $imageData;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Add your styles here */
        @page {
            margin: 100px 25px;
            /* Adjust margins for the header */
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: #f5f5f5;
            color: #333;
            text-align: center;
            line-height: 50px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        h1,
        h2 {
            font-size: 18px;
        }

        .leading-paragraph {
            text-align: justify;
            margin-bottom: 15px;
        }

        .indented-paragraph {
            text-indent: 35px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .indented-paragraph-list {
            padding-left: 50px;
            margin-bottom: 0px;
            line-height: 1;
        }

        .numbered-paragraph {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.5;
            text-indent: -30px;
            /* Indent the number out of the paragraph */
            padding-left: 30px;
            /* Offset the paragraph text to align after the number */
        }

        .numbered-paragraphChild {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.5;
            text-indent: 0px;
            /* Indent the number out of the paragraph */
            padding-left: 35px;
            /* Offset the paragraph text to align after the number */
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .page-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* Full viewport height */
            text-align: center;
        }

        label {
            display: block;
        }

        /* General Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            font-size: 18px !important;
        }

        /* Header row styling */
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        /* Title row styling */
        th {
            background-color: #002060;
            color: white;
            font-weight: bold;
        }

        /* Column Headers */
        .section-title {
            font-weight: bold;
            width: 40%;
            font-size: 18px;
        }

        /* Subheaders with merged cells */
        .subheader {
            font-weight: bold;
            vertical-align: top;
            text-align: left;
            width: 20%;
            font-size: 18px;
        }

        /* Instructions text */
        .instructions {
            font-style: italic;
            font-size: 12px;
            margin: 0px;
            padding: 0px;
        }

        /* Special row for title of the part */
        .part-title {
            background-color: #002060;
            color: white;
            text-align: left;
            font-weight: bold;
            padding: 8px;
            font-size: 18px;
        }

        .textarea {
            width: 100%;
        }
    </style>
</head>

<body>
    <div style="width: 100%; text-align: center; margin-top: -30px;">
        <div style="display: inline-block; vertical-align: top; width: 100px;">
            <img src="{{ $aufLogo }}" style="height: 100px;">
        </div>
        <div
            style="display: inline-block; vertical-align: top; text-align: center; margin-left: 20px; margin-top: 20px;">
            <h1 style="margin: 0;"> ANGELES UNIVERSITY FOUNDATION </h1>
            <h2 style="margin: 0;"> OFFICE OF GLOBAL RELATIONS </h2>
        </div>
    </div>

    <br>

    <h1 class="text-center"> PARTNERSHIP ENDORSEMENT FORM </h1>
    <div class="content">
        <p class="leading-paragraph">
            <span class="bold">Directions: </span>
            Please be informed that this “Partnership Endorsement Form” shall be accomplished by the concerned AUF unit. 
            The objective of this endorsement form is to establish the need of the University to be partnered with the 
            prospective local and international partner. This endorsement form, together with the accomplished partnership 
            proposal form, shall be sent to the OGR email address
            <a href="mailto:ogr@auf.edu.ph">ogr@auf.edu.ph</a>.
            We will review your proposal and notify you of the next steps to be taken. For any inquiries or clarifications, 
            please feel free to contact us at +63 045 625 2888 local 1783.
        </p>

        <table>
            <!-- Part I -->
            <tr>
                <th class="part-title">ENDORSEMENT THE PROPOSED PARTNERSHIP</th>
            </tr>
            <!-- Question #1 -->
            <tr>
                <td> 
                    <span class="bold"> 1.1. Describe the need for the target students/faculty researchers to be trained or educated under the proposed partnership. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_1}}</p>
                </td>
            </tr>

            <!-- Question #2 -->
            <tr>
                <td> 
                    <span class="bold"> Describe the potential contributions of the prospective partner to the strengthening of the AUF. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_2}}</p>
                </td>
            </tr>

            <!-- Question #3 -->
            <tr>
                <td> 
                    <span class="bold"> 1.3. Describe the potential contributions of the prospective partner to the improvement of the community. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_3}}</p>
                </td>
            </tr>

            <!-- Question #4 -->
            <tr>
                <td> 
                    <span class="bold"> 1.4. Describe the potential contributions of the prospective partner to the economic growth of the community. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_4}}</p>
                </td>
            </tr>

            <!-- Question #5 -->
            <tr>
                <td> 
                    <span class="bold"> 1.5. Describe the potential contributions of the prospective partner to the innovation of the AUF. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_5}}</p>
                </td>
            </tr>

            <!-- Question #6 -->
            <tr>
                <td> 
                    <span class="bold"> 1.6. Describe how the delivery of the proposed partnership will contribute to the AUF institutional goals. Specify the targeted KPI of the college/unit and the university for the proposed partnership. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_6}}</p>
                </td>
            </tr>

            <!-- Question #7 -->
            <tr>
                <td> 
                    <span class="bold"> 1.7. Describe which among the Sustainable Development Goals (SDG) will be addressed in the delivery of the proposed partnership. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_7}}</p>
                </td>
            </tr>

            <!-- Question #8 -->
            <tr>
                <td> 
                    <span class="bold"> 1.8. Describe any additional equipment, facilities, IT resources, or other University resources needed for the execution of the proposed partnership. </span>
                    <p class="indented-paragraph"> {{$endorsement->endorsement_1_8}}</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
