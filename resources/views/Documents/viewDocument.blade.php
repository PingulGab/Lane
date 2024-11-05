@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')
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
<h2>Document Details</h2>

<div class="biContainer">
    <div class="biContainer-area1">
        <div class="previewStyle">
            <div id="memorandum-content" style="display: none;">
                @include('components.documents_preview.moa')
            </div>
            <div id="proposal-content" style="display: none;">
                @include('components.documents_preview.proposal')
            </div>
            <div id="endorsement-content" style="display: none;">
                @include('components.documents_preview.endorsement')
            </div>
        </div>
        <div style="display: flex; flex-direction: row;">
            <div style="margin-bottom: 10px;">
                <!-- Buttons to toggle views -->
                <button onclick="showMemorandum()" id="view-memorandum-button">View Memorandum</button>
                <button onclick="showProposal()" id="view-proposal-button">View Proposal</button>
                <button onclick="showEndorsement()" id="view-endorsement-button">View Endorsement</button>
            </div>
            <div id="dropdown-container">
                <select id="page-selector" onchange="navigateToPage()">
                    <option value="page1">Title Page</option>
                    <option value="page2">Introduction</option>
                    <option value="page3">Article 1: Program Overview</option>
                    <option value="page4">Article 2: Representation and Warranties</option>
                    <option value="page5">Article 3: Scope of Collaboration</option>
                    <option value="page6">Article 4: Responsibilities of AUF</option>
                    <option value="page7">Article 5: Responsibilities of {{ $document->proposalForm->institution_name_acronym }}</option>
                    <option value="page8">Article 6: Responsibilities of AUF and {{ $document->proposalForm->institution_name_acronym }}</option>
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
        <h3>Approval Status</h3>
        <table class="xxx" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="1">Affiliate</th>
                    <th colspan="1">Status</th>
                    <th> Approved At </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($document->approvals as $approval)
                    <tr>
                        <td colspan="1">{{ $approval->affiliate->name }}</td>
                        <td colspan="1">{{ $approval->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td> {{$approval->approved_at}} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Show Memorandum content and show the dropdown
    function showMemorandum() {
        document.getElementById('memorandum-content').style.display = 'block';
        document.getElementById('proposal-content').style.display = 'none';
        document.getElementById('endorsement-content').style.display = 'none';
        document.getElementById('view-memorandum-button').classList.add('active');
        document.getElementById('view-proposal-button').classList.remove('active');
        document.getElementById('view-endorsement-button').classList.remove('active');

        // Show the dropdown container
        document.getElementById('dropdown-container').style.display = 'block';
    }

    // Show Proposal content and hide the dropdown
    function showProposal() {
        document.getElementById('proposal-content').style.display = 'block';
        document.getElementById('memorandum-content').style.display = 'none';
        document.getElementById('endorsement-content').style.display = 'none';
        document.getElementById('view-proposal-button').classList.add('active');
        document.getElementById('view-memorandum-button').classList.remove('active');
        document.getElementById('view-endorsement-button').classList.remove('active');

        // Hide the dropdown container
        document.getElementById('dropdown-container').style.display = 'none';
    }

    // Show Endorsement content and hide the dropdown
    function showEndorsement() {
        document.getElementById('endorsement-content').style.display = 'block';
        document.getElementById('proposal-content').style.display = 'none';
        document.getElementById('memorandum-content').style.display = 'none';
        document.getElementById('view-endorsement-button').classList.add('active');
        document.getElementById('view-proposal-button').classList.remove('active');
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