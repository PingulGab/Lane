@extends('layouts.nonAdmin')

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
</style>
<h1> Affiliate View - Approving </h1>
<div class="biContainer">
    <div class="biContainer-area1">
        <div class="previewStyle">
            @include('components.documents_preview.moa')
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
    <div class="biContainer-area2">
        <div id="versionHistory">
            <h3>Version History</h3>
            <ul>
                @foreach($document->memorandum->versions as $version)
                    @if($version->version !== '1.0')
                        <li>
                            <a href="{{ route('compareVersion', ['id' => $document->memorandum->id, 'version' => $version->version]) }}" class="btn btn-primary">
                                Version {{ $version->version }}
                            </a>
                            (Edited by: {{ $version->editor->name ?? 'Unknown' }})
                        </li>
                    @endif
                @endforeach
            
                <li>
                    <a href="{{ route('compareVersion', ['id' => $document->memorandum->id, 'version' => $document->memorandum->version]) }}" class="btn btn-primary">
                        Version {{ $document->memorandum->version }} (Last Edit)
                    </a>
                    (Edited by: {{ $document->memorandum->editor->name ?? 'Unknown' }})
                </li>
            </ul>  
        </div>
    </div>
</div>

<script>
    function navigateToPage() {
        const selector = document.getElementById('page-selector');
        const pageId = selector.value;

        if (pageId) {
            document.getElementById(pageId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
</script>
@endsection