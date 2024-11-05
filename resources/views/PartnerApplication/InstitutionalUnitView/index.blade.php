@extends('layouts.nonAdmin')

@section('title', 'LANE - Dashboard')

@section('content')

<?php

$path = public_path('images/auf_logo.png'); // Corrected path for the image
$imageData = base64_encode(file_get_contents($path));
$aufLogo = 'data:image/png;base64,' . $imageData;

?>

<style>
    .previewStyle {
        font-family: 'Times New Roman', serif;
        font-size: 18px;
        width: 70vh;
        height: 70vh;
        overflow: auto;
        text-align: justify;
        background-color: white;
        padding: 30px;
        border-radius: 15px;
    }

    .biContainer {
        display: flex;
    }

    .biContainer-area1 {
        flex: 1;
    }

    .biContainer-area2 {
        flex: 1;
    }

    
    /* Optional: Styling for active button state */
    .active {
            background-color: #4CAF50; /* Green */
            color: white;
        }

    textarea {
        width: 100%;
        height: 10vh;
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="biContainer">
    <div class="biContainer-area1">
        <h1>View Submitted MOA & Proposal Form</h1>
        <div class="previewStyle">
            <!-- Content areas for each view -->
            <div id="memorandum-content" style="display: none;">
                @include('components.memorandum._memorandum_preview')
            </div>

            <div id="proposal-content" style="display: none;">
                @include('components.proposal_form._proposal_form_preview')
            </div>
        </div>
        <div style="display: flex; flex-direction: row;">
            <div style="margin-bottom: 10px;">
                <!-- Buttons to toggle views -->
                <button onclick="showMemorandum()" id="view-memorandum-button">View Memorandum</button>
                <button onclick="showProposal()" id="view-proposal-button">View Proposal</button>
            </div>
            <div id="dropdown-container">
                <select id="page-selector" onchange="navigateToPage()">
                    <option value="page1">Title Page</option>
                    <option value="page2">Introduction</option>
                    <option value="page3">Article 1: Program Overview</option>
                    <option value="page4">Article 2: Representation and Warranties</option>
                    <option value="page5">Article 3: Scope of Collaboration</option>
                    <option value="page6">Article 4: Responsibilities of AUF</option>
                    <option value="page7">Article 5: Responsibilities of {{ $proposalForm->institution_name_acronym }}</option>
                    <option value="page8">Article 6: Responsibilities of AUF and {{ $proposalForm->institution_name_acronym }}</option>
                    <option value="page9">Article 7: Intellectual Property Rights</option>
                    <option value="page10">Article 8: Employment Relations</option>
                    <option value="page11">Article 9: Exclusivity</option>
                    <option value="page12">Article 10: Material Adverse Change Clause</option>
                    <option value="page13">Article 11: Confidentiality</option>
                    <option value="page14">Article 12: Compliance with Law</option>
                    <option value="page15">Article 13: Non-Assignment of Rights</option>
                    <option value="page16">Article 14: Severability</option>
                    <option value="page17">Article 15: Effectivity</option>
                    <option value="page18">Article 16: Amendments</option>
                    <option value="page19">Article 17: Governing Law</option>
                    <option value="page20">Article 18: Dispute Resolution</option>
                    <option value="page21">Article 19: Venue of Action</option>
                    <option value="page22">Article 20: Notices</option>
                    <option value="page23">Article 21: Subsequent Agreements</option>
                </select>
            </div>
        </div>
    </div>

    <div class="biContainer-area2">
        <h1>Create Endorsement Form</h1>
        <form id="multi-step-form" action="{{ route('generateEndorsement', ['link' => $link->link])}}" method="POST">
            @csrf
            <div class="previewStyle">
                <div class="endorsement-form-container">
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
                                <textarea name="endorsement_1_1" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #2 -->
                        <tr>
                            <td> 
                                <span class="bold"> Describe the potential contributions of the prospective partner to the strengthening of the AUF. </span>
                                <textarea name="endorsement_1_2" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #3 -->
                        <tr>
                            <td> 
                                <span class="bold"> 1.3. Describe the potential contributions of the prospective partner to the improvement of the community. </span>
                                <textarea name="endorsement_1_3" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #4 -->
                        <tr>
                            <td> 
                                <span class="bold"> 1.4. Describe the potential contributions of the prospective partner to the economic growth of the community. </span>
                                <textarea name="endorsement_1_4" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #5 -->
                        <tr>
                            <td> 
                                <span class="bold"> 1.5. Describe the potential contributions of the prospective partner to the innovation of the AUF. </span>
                                <textarea name="endorsement_1_5" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #6 -->
                        <tr>
                            <td> 
                                <span class="bold"> 1.6. Describe how the delivery of the proposed partnership will contribute to the AUF institutional goals. Specify the targeted KPI of the college/unit and the university for the proposed partnership. </span>
                                <textarea name="endorsement_1_6" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #7 -->
                        <tr>
                            <td> 
                                <span class="bold"> 1.7. Describe which among the Sustainable Development Goals (SDG) will be addressed in the delivery of the proposed partnership. </span>
                                <textarea name="endorsement_1_7" style="block; " required> </textarea>
                            </td>
                        </tr>

                        <!-- Question #8 -->
                        <tr>
                            <td> 
                                <span class="bold"> 1.8. Describe any additional equipment, facilities, IT resources, or other University resources needed for the execution of the proposed partnership. </span>
                                <textarea name="endorsement_1_8" style="block; " required> </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bold"> OVPS needed: </span>
                                @foreach($affiliateList as $affiliate)
                                    <div>
                                        <input type="checkbox" name="selected_affiliates[]" value="{{ $affiliate->id }}" id="affiliate_{{ $affiliate->id }}">
                                        <label style="display: inline" for="affiliate_{{ $affiliate->id }}">{{ $affiliate->name }}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <a href="{{ route('editMemorandum', ['id' => $memorandum->id]) }}" class="btn btn-warning">Edit</a>
            <button type="submit" class="submit-btn" onclick="prepareSubmission()">Submit</button>
        </form>
    </div>
</div>

    

<script>
    // Show Memorandum content and show the dropdown
    function showMemorandum() {
        document.getElementById('memorandum-content').style.display = 'block';
        document.getElementById('proposal-content').style.display = 'none';
        document.getElementById('view-memorandum-button').classList.add('active');
        document.getElementById('view-proposal-button').classList.remove('active');

        // Show the dropdown container
        document.getElementById('dropdown-container').style.display = 'block';
    }

    // Show Proposal content and hide the dropdown
    function showProposal() {
        document.getElementById('proposal-content').style.display = 'block';
        document.getElementById('memorandum-content').style.display = 'none';
        document.getElementById('view-proposal-button').classList.add('active');
        document.getElementById('view-memorandum-button').classList.remove('active');

        // Hide the dropdown container
        document.getElementById('dropdown-container').style.display = 'none';
    }

    function navigateToPage() {
        const selector = document.getElementById('page-selector');
        const pageId = selector.value;

        if (pageId) {
            document.getElementById(pageId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    // Initialize with Memorandum view (or Proposal if you prefer)
    document.addEventListener("DOMContentLoaded", function() {
        showMemorandum(); // Set default view to Memorandum
    });
</script>

@endsection