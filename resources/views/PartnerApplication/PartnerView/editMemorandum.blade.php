@php
    
    $whereasClauses = is_string($memorandum->whereas_clauses) ? json_decode($memorandum->whereas_clauses, true) : $memorandum->whereas_clauses;
    if (is_array($whereasClauses)) {
        foreach ($whereasClauses as $index => $clause) {
            if (is_array($clause)) {
                // Convert nested arrays to string (customize this as needed for your specific structure)
                $whereasClauses[$index] = implode(', ', $clause);
            }
        }
    }

@endphp

@extends('layouts.Nonadmin')

@section('content')
<style>
    .memorandum_container_preview {
        display: flex;
        justify-content: center;
    }

    .memorandum_container_preview h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .previewStyle {
        font-family: 'Times New Roman', serif;
        font-size: 18px;
        width: 70vh;
        height: 80vh;
        overflow: auto;
        text-align: justify;
        background-color: white;
        padding: 30px;
        border-radius: 15px;
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
        text-indent: -30px;  /* Indent the number out of the paragraph */
        padding-left: 30px;  /* Offset the paragraph text to align after the number */
    }

    .numbered-paragraphChild {
        text-align: justify;
        margin-bottom: 15px;
        line-height: 1.5;
        text-indent: 0px;  /* Indent the number out of the paragraph */
        padding-left: 35px;  /* Offset the paragraph text to align after the number */
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

    .navigator-container {
        display: flex;
        justify-content: center;
    }

    .navigator {
        background-color: white;
        border-radius: 20px;
        padding: 20px;
        width: 70vh;
    }

    .menu-container {
        display: flex;
        justify-content: center;
    }

    .menu {
        background-color: white;
        margin-top: 25px;

        border-radius: 20px;
        padding: 20px;
        width: 70vh;
    }
</style>
<!--- Memorandum (Agreement) --->
<form method="POST" action="{{ route('submitProspectPartnerFormMemorandum', $link->link) }}">
    @csrf
    <h1> Memorandum </h1>
    <div class="memorandum-form-container">
        <div class="memorandum-form-container-area1">

            <!-- Section 0: First Page -->
            <div class="form-section hidden" id="step-0">
                <div class="memorandum_container_preview">
                    <div class="article0-preview previewStyle" id="article0-preview">
                        @include('components.memorandum._firstPage')
                    </div>
                </div>
            </div>

            <!-- Section 1: Witnesseth Section -->
            <div class="form-section" id="step-1">
                <input type="hidden" class="form-control" id="partner_name" name="partner_name"
                    value="{{ $link->proposalform->institution_name_acronym }}" disabled>
                <!--- First Page + Witnesseth Section Preview --->
                <div class="memorandum_container_preview">
                    <div class="previewStyle">
                        <div class="witnesseth-section-preview" id="witnesseth-section-preview">
                            @include('components.memorandum._witnessethSection', ['link' => $link])
                        </div>
                        @include('components.memorandum._witnessethSection2', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 2: Program Overview -->
            <div class="form-section hidden" id="step-2">
                <div class="memorandum_container_preview">
                    <div class="article1-preview previewStyle" id="article1-preview">
                        @include('components.memorandum._article1')
                    </div>
                </div>
            </div>

            <!-- Section 3: Representation and Warranties -->
            <div class="form-section hidden" id="step-3">
                <div class="memorandum_container_preview">
                    <div class="article2-preview previewStyle" id="article2-preview">
                        @include('components.memorandum._article2', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 4: Scope of Collaboration -->
            <div class="form-section hidden" id="step-4">
                <div class="memorandum_container_preview">
                    <div class="article3-preview previewStyle" id="article3-preview">
                        @include('components.memorandum._article3', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 5: Responsibilities of Partner -->
            <div class="form-section hidden" id="step-5">
                <div class="memorandum_container_preview">
                    <div class="article5-preview previewStyle" id="article5-preview">
                        @include('components.memorandum._article5', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 6: Responsibilities of AUF and Partner -->
            <div class="form-section hidden" id="step-6">
                <div class="memorandum_container_preview">
                    <div class="article6-preview previewStyle" id="article6-preview">
                        @include('components.memorandum._article6', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 7: Intellectual Property Rights -->
            <div class="form-section hidden" id="step-7">
                <div class="memorandum_container_preview">
                    <div class="article7-preview previewStyle" id="article7-preview">
                        @include('components.memorandum._article7', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 8: Employment Relations -->
            <div class="form-section hidden" id="step-8">
                <div class="memorandum_container_preview">
                    <div class="article8-preview previewStyle" id="article8-preview">
                        @include('components.memorandum._article8', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 9: Exclusivity -->
            <div class="form-section hidden" id="step-9">
                <div class="memorandum_container_preview">
                    <div class="article9-preview previewStyle" id="article9-preview">
                        @include('components.memorandum._article9', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 10: Material Adverse Change Clause -->
            <div class="form-section hidden" id="step-10">
                <div class="memorandum_container_preview">
                    <div class="article10-preview previewStyle" id="article10-preview">
                        @include('components.memorandum._article10', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 11: Confidentiality -->
            <div class="form-section hidden" id="step-11">
                <div class="memorandum_container_preview">
                    <div class="article11-preview previewStyle" id="article11-preview">
                        @include('components.memorandum._article11', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 12: Compliance with Law -->
            <div class="form-section hidden" id="step-12">
                <div class="memorandum_container_preview">
                    <div class="article12-preview previewStyle" id="article12-preview">
                        @include('components.memorandum._article12', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 13: Non-Assignment of Rights -->
            <div class="form-section hidden" id="step-13">
                <div class="memorandum_container_preview">
                    <div class="article13-preview previewStyle" id="article13-preview">
                        @include('components.memorandum._article13', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 14: Severability -->
            <div class="form-section hidden" id="step-14">
                <div class="memorandum_container_preview">
                    <div class="article14-preview previewStyle" id="article14-preview">
                        @include('components.memorandum._article14', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 15: Effectivity -->
            <div class="form-section hidden" id="step-15">
                <div class="memorandum_container_preview">
                    <div class="article15-preview previewStyle" id="article15-preview">
                        @include('components.memorandum._article15', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 16: Amendments -->
            <div class="form-section hidden" id="step-16">
                <div class="memorandum_container_preview">
                    <div class="article16-preview previewStyle" id="article16-preview">
                        @include('components.memorandum._article16', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 17: Governing Law -->
            <div class="form-section hidden" id="step-17">
                <div class="memorandum_container_preview">
                    <div class="article17-preview previewStyle" id="article17-preview">
                        @include('components.memorandum._article17', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 18: Governing Law -->
            <div class="form-section hidden" id="step-18">
                <div class="memorandum_container_preview">
                    <div class="article18-preview previewStyle" id="article18-preview">
                        @include('components.memorandum._article18', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 19: Governing Law -->
            <div class="form-section hidden" id="step-19">
                <div class="memorandum_container_preview">
                    <div class="article19-preview previewStyle" id="article19-preview">
                        @include('components.memorandum._article19', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 20: Notices -->
            <div class="form-section hidden" id="step-20">
                <div class="memorandum_container_preview">
                    <div class="previewStyle">
                        <div class="article20-preview" id="article20-preview">
                            @include('components.memorandum._article20', ['link' => $link])
                        </div>
                        @include('components.memorandum._article20_contacts', ['link' => $link])
                    </div>
                </div>
            </div>

            <!-- Section 21: Notices -->
            <div class="form-section hidden" id="step-21">
                <div class="memorandum_container_preview">
                    <div class="previewStyle">
                        <div class="article21-preview" id="article21-preview">
                            @include('components.memorandum._article21', ['link' => $link])
                        </div>
                        @include('components.memorandum._lastPage')
                    </div>
                </div>
            </div>

        </div>

        <div class="memorandum-form-container-area2">
            <!-- Dropdown to Navigate between Sections -->
            <div class="navigator-container">
                <div class="form-group navigator">
                    <h2 id="section-navigation-header">Step 1: Witnesseth Section</h2>
                    <label for="section-navigator">Jump to Section:</label>
                    <select id="section-navigator" class="form-control">

                    </select>

                    <!-- Move Navigation Buttons Here -->
                    <div id="navigation-buttons">
                        <button type="button" class="btn btn-secondary" id="previous-step">Previous</button>
                        <button type="button" class="btn btn-primary" id="next-step">Next</button>
                        <button type="submit" class="btn btn-success" id="submit-form"
                            style="display: none;">Submit</button>
                    </div>
                </div>
            </div>

            <!-- Option for Step #0 -->
            <div class="menu-container">
                <div class="menu" id="article0Menu" style="display: none;">
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" class="form-control" name="partnership_title" id="partnership_title" placeholder="" required value="{{$memorandum->partnership_title}}">
                    </div>
                </div>
            </div>

            <!-- Options for Step #1 -->
            <div class="menu-container">
                <div class="menu" id="whereas-section-options" style="display: none;">
                    <!-- Edit Dropdown Options with Tag-like Input -->
                    <div class="form-group">
                        <label for="custom_options">Edit Dropdown Options</label>
                        <div style="display: flex;">
                            <div id="tags-container" class="form-control"
                                style="display: flex; min-height: 30px;">
                                <!-- Tags will appear here -->
                            </div>
                            <button type="button" class="btn btn-secondary" id="edit-options-btn">Edit</button>
                            <button type="button" class="btn btn-secondary" id="save-options-btn"
                                style="display: none;">Save</button>
                        </div>
                        <input type="text" class="form-control" id="tag-input"
                            placeholder="Type and press comma (,) to add"
                            style="display: none; margin-top: 5px; min-width:300px;">
                    </div>

                    <!-- Whereas Clauses Container -->
                    <div id="whereas-clauses-container">
                        <br><label>Whereas Clauses</label>
                        <br>
                        <small class="error-message text-danger" id="whereas_clause_error"></small>
                        <!-- First Whereas Clause -->
                        <div class="form-group whereas-clause-item">
                            <label>Whereas,</label>
                            <select class="whereas-clause-select form-control" name="whereas_clauses[]">
                                <option value="the AUF">the AUF</option>
                                <option value="AUF">AUF</option>
                                <option value="{{ $link->proposalform->institution_name_acronym }}">
                                    {{ $link->proposalform->institution_name_acronym }}</option>
                                <option value="the {{ $link->proposalform->institution_name_acronym }}">the
                                    {{ $link->proposalform->institution_name_acronym }}</option>
                                <option value="the AUF and {{ $link->proposalform->institution_name_acronym }}">
                                    The AUF and {{ $link->proposalform->institution_name_acronym }}</option>
                            </select>
                            <textarea class="form-control" name="whereas_clause_texts[]" placeholder="Enter full Whereas Clause" required></textarea>
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-whereas-clause-btn">Add Another
                        Whereas Clause</button>
                </div>
            </div>

            <!-- Options for Step #2 -->
            <div class="menu-container">
                <div class="menu" id="article1Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article1MenuContainer">
                        <small class="error-message text-danger" id="article1ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_1) as $index => $article)
                                <div class="form-group article1Item">
                                    <textarea class="form-control" name="article1[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-2">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article1-btn">Add Another
                        Entry</button>
                </div>
            </div>

            <!-- Option for Step #3 -->
            <div class="menu-container">
                <div class="menu" id="article2Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article2MenuContainer">
                        <small class="error-message text-danger" id="article2ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_2_partner) as $index => $article)
                                <div class="form-group article2Item">
                                    <textarea class="form-control" name="article2[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-2">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article2-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #4 -->
            <div class="menu-container">
                <div class="menu" id="article3Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article3MenuContainer">
                        <small class="error-message text-danger" id="article3ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_3) as $index => $article)
                                <div class="form-group article3Item">
                                    <textarea class="form-control" name="article3[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article3-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #5 -->
            <div class="menu-container">
                <div class="menu" id="article5Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article5MenuContainer">
                        <small class="error-message text-danger" id="article5ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_5) as $index => $article)
                                <div class="form-group article5Item">
                                    <textarea class="form-control" name="article5[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article5-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #6 -->
            <div class="menu-container">
                <div class="menu" id="article6Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article6MenuContainer">
                        <small class="error-message text-danger" id="article6ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_6) as $index => $article)
                                <div class="form-group article6Item">
                                    <textarea class="form-control" name="article6[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article6-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #7 -->
            <div class="menu-container">
                <div class="menu" id="article7Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article7MenuContainer">
                        <small class="error-message text-danger" id="article7ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_7) as $index => $article)
                                <div class="form-group article7Item">
                                    <textarea class="form-control" name="article7[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article7-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #8 -->
            <div class="menu-container">
                <div class="menu" id="article8Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article8MenuContainer">
                        <small class="error-message text-danger" id="article8ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_8) as $index => $article)
                                <div class="form-group article8Item">
                                    <textarea class="form-control" name="article8[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article8-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #9 -->
            <div class="menu-container">
                <div class="menu" id="article9Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article9MenuContainer">
                        <small class="error-message text-danger" id="article9ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_9) as $index => $article)
                                <div class="form-group article9Item">
                                    <textarea class="form-control" name="article9[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article9-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #10 -->
            <div class="menu-container">
                <div class="menu" id="article10Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article10MenuContainer">
                        <small class="error-message text-danger" id="article10ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_10) as $index => $article)
                                <div class="form-group article10Item">
                                    <textarea class="form-control" name="article10[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article10-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #11 -->
            <div class="menu-container">
                <div class="menu" id="article11Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article11MenuContainer">
                        <small class="error-message text-danger" id="article11ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_11) as $index => $article)
                                <div class="form-group article11Item">
                                    <textarea class="form-control" name="article11[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article11-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #12 -->
            <div class="menu-container">
                <div class="menu" id="article12Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article12MenuContainer">
                        <small class="error-message text-danger" id="article12ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_12) as $index => $article)
                                <div class="form-group article12Item">
                                    <textarea class="form-control" name="article12[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article12-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #13 -->
            <div class="menu-container">
                <div class="menu" id="article13Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article13MenuContainer">
                        <small class="error-message text-danger" id="article13ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_13) as $index => $article)
                                <div class="form-group article13Item">
                                    <textarea class="form-control" name="article13[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article13-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #14 -->
            <div class="menu-container">
                <div class="menu" id="article14Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article14MenuContainer">
                        <small class="error-message text-danger" id="article14ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_14) as $index => $article)
                                <div class="form-group article14Item">
                                    <textarea class="form-control" name="article14[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article14-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #15 -->
            <div class="menu-container">
                <div class="menu" id="article15Menu" style="display: none;">
                    <!-- Duration Input for Step #15 -->
                    <div class="form-group">
                        <label>Duration:</label>
                        <?php 
                            //Get Number
                            $string = $memorandum->validity_period;
                            $parts = explode(' ', $string);
                            $validity = (int)$parts[0];

                            $timeUnit = strtolower($parts[1]);

                            // Normalize the time unit (to match the dropdown options)
                            if ($timeUnit === 'days' || $timeUnit === 'day') {
                                $selectedTimeUnit = 'day';
                            } elseif ($timeUnit === 'months' || $timeUnit === 'month') {
                                $selectedTimeUnit = 'month';
                            } elseif ($timeUnit === 'years' || $timeUnit === 'year') {
                                $selectedTimeUnit = 'year';
                            } else {
                                // Handle case where the time unit is unknown
                                $selectedTimeUnit = 'day'; // Default fallback
                            }
                        ?>
                        <input type="number" class="form-control" id="durationInput" placeholder="Enter number" min="1" value="{{$validity}}" required>
                    </div>
                    <div class="form-group">
                        <label>Time Unit:</label>
                        <select class="form-control" id="timeUnitDropdown">
                            <option value="day" <?php if ($selectedTimeUnit === 'day') echo 'selected'; ?>>Day</option>
                            <option value="month" <?php if ($selectedTimeUnit === 'month') echo 'selected'; ?>>Month</option>
                            <option value="year" <?php if ($selectedTimeUnit === 'year') echo 'selected'; ?>>Year</option>
                        </select>
                    </div>

                    <input type="hidden" name="combined_duration" id="combined-duration">

                    <!-- Program Overview Container -->
                    <div id="article15MenuContainer">
                        <small class="error-message text-danger" id="article15ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_15) as $index => $article)
                                <div class="form-group article15Item">
                                    <textarea class="form-control" name="article15[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article15-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #16 -->
            <div class="menu-container">
                <div class="menu" id="article16Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article16MenuContainer">
                        <small class="error-message text-danger" id="article16ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_16) as $index => $article)
                                <div class="form-group article16Item">
                                    <textarea class="form-control" name="article16[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article16-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #17 -->
            <div class="menu-container">
                <div class="menu" id="article17Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article17MenuContainer">
                        <small class="error-message text-danger" id="article17ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_17) as $index => $article)
                                <div class="form-group article17Item">
                                    <textarea class="form-control" name="article17[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article17-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #18 -->
            <div class="menu-container">
                <div class="menu" id="article18Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article18MenuContainer">
                        <small class="error-message text-danger" id="article18ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_18) as $index => $article)
                                <div class="form-group article18Item">
                                    <textarea class="form-control" name="article18[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article18-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #19 -->
            <div class="menu-container">
                <div class="menu" id="article19Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article19MenuContainer">
                        <small class="error-message text-danger" id="article19ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_19) as $index => $article)
                                <div class="form-group article19Item">
                                    <textarea class="form-control" name="article19[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article19-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #20 -->
            <div class="menu-container">
                <div class="menu" id="article20Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article20MenuContainer">
                        <small class="error-message text-danger" id="article20ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_20) as $index => $article)
                                <div class="form-group article20Item">
                                    <textarea class="form-control" name="article20[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article20-btn">Add Another Entry</button>
                </div>
            </div>

            <!-- Option for Step #21 -->
            <div class="menu-container">
                <div class="menu" id="article21Menu" style="display: none;">
                    <!-- Program Overview Container -->
                    <div id="article21MenuContainer">
                        <small class="error-message text-danger" id="article21ErrorMessage"></small>
                        <!-- First Entry -->
                        <div class="form-group">
                            <label>Entry</label>
                            @foreach(json_decode($memorandum->article_21) as $index => $article)
                                <div class="form-group article21Item">
                                    <textarea class="form-control" name="article21[]" required>{{ $article }}</textarea>
                                    <button type="button" class="btn btn-danger mt-3">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add New Clause Button -->
                    <button type="button" class="btn btn-secondary" id="add-article21-btn">Add Another Entry</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // JavaScript to update the reason dynamically
    document.addEventListener('DOMContentLoaded', function() {
        const partnershipTitle = document.getElementById('partnership_title').value;
        document.getElementById('titleDisplay').textContent = partnershipTitle;
        console.log(partnershipTitle);
    });
    document.getElementById('partnership_title').addEventListener('input', function() {
            // Get the input value
            const reason = this.value;
            // Update the content of the reason display element
            document.getElementById('titleDisplay').textContent = reason;
        });

    //Add Whereas Clause
    document.addEventListener('DOMContentLoaded', function() {
        const partnerNameInput = document.getElementById('partner_name');
        const tagInput = document.getElementById('tag-input');
        const tagsContainer = document.getElementById('tags-container');
        const editOptionsBtn = document.getElementById('edit-options-btn');
        const saveOptionsBtn = document.getElementById('save-options-btn');
        let isEditing = false;
        let debounceTimeout;
        let previousPartnerName = partnerNameInput.value; // Preload the initial partner name
        let tags = ['the AUF', 'AUF', `the ${previousPartnerName}`, `${previousPartnerName}`,
            `the AUF and ${previousPartnerName}`
        ]; // Default tags

        // Render initial tags (non-editable)
        renderTags();

        // Function to update the tags based on partner name input
        function updatePartnerNameTags(partnerName) {
            // Remove previous partner name-related tags
            tags = tags.filter(tag => tag !== previousPartnerName && tag !==
                `the AUF and ${previousPartnerName}`);

            // Add new partner name tags if partnerName is not empty
            if (partnerName) {
                tags.push(partnerName);
                tags.push(`the AUF and ${partnerName}`);
            }

            // Update the previous partner name to the current one
            previousPartnerName = partnerName;

            // Re-render tags after updating
            renderTags();

            //Update Dropdown Menu
            updateDropdownOptions();
        }

        // Debounced function for partner name input
        function updatePartnerNameTagsDebounced() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const partnerName = partnerNameInput.value.trim();
                updatePartnerNameTags(partnerName); // Call the function to update tags
            }, 300); // Debounce delay (300ms)
        }

        // Listen to partner name input with debouncing
        partnerNameInput.addEventListener('input', updatePartnerNameTagsDebounced);


        // Toggle between Edit and Save modes
        editOptionsBtn.addEventListener('click', function() {
            if (!isEditing) {
                // Enable editing
                tagInput.style.display = 'block'; // Show input box
                editOptionsBtn.style.display = 'none'; // Hide "Edit" button
                saveOptionsBtn.style.display = 'block'; // Show "Save" button
                isEditing = true;
                renderTags(true); // Make tags removable
            }
        });

        saveOptionsBtn.addEventListener('click', function() {
            // Save changes, disable editing
            tagInput.style.display = 'none'; // Hide input box
            saveOptionsBtn.style.display = 'none'; // Hide "Save" button
            editOptionsBtn.style.display = 'block'; // Show "Edit" button
            isEditing = false;
            renderTags(); // Make tags non-removable
        });

        // Listen for input in the tag input box
        tagInput.addEventListener('keypress', function(e) {
            if (e.key === ',' || e.key === 'Enter') {
                e.preventDefault();
                const tagValue = tagInput.value.trim();
                if (tagValue) {
                    addTag(tagValue);
                    tagInput.value = ''; // Clear input after adding the tag
                }
            }
        });

        // Function to add a new tag
        function addTag(tagValue) {
            // Prevent duplicate tags
            if (!tags.includes(tagValue)) {
                tags.push(tagValue);
                renderTags(isEditing);
            }
        }

        // Function to render tags in the tags container
        function renderTags(removable = false) {
            tagsContainer.innerHTML = ''; // Clear the container

            tags.forEach(tag => {
                const tagElement = document.createElement('span');
                tagElement.classList.add('tag');
                tagElement.style =
                    'background-color: #e0e0e0; border-radius: 4px; padding: 5px 10px; margin-right: 5px; display: flex; align-items: center; font-size: 0.8rem;';

                // Tag text
                const tagText = document.createElement('span');
                tagText.innerText = tag;
                tagElement.appendChild(tagText);

                // Remove button (x) if in editing mode
                if (removable) {
                    const removeBtn = document.createElement('button');
                    removeBtn.innerText = 'x';
                    removeBtn.style =
                        'border: none; background: transparent; color: red; margin-left: 10px; cursor: pointer;';
                    removeBtn.addEventListener('click', function() {
                        removeTag(tag);
                    });
                    tagElement.appendChild(removeBtn);
                }

                tagsContainer.appendChild(tagElement);
            });
        }

        // Function to remove a tag
        function removeTag(tag) {
            tags = tags.filter(t => t !== tag);
            renderTags(isEditing);
        }

        // Save the tags and update the dropdown options
        saveOptionsBtn.addEventListener('click', function() {
            updateDropdownOptions();
        });

        // Function to update the dropdown options based on tags
        function updateDropdownOptions() {
            // Loop through all dropdowns and preserve their selected values
            document.querySelectorAll('.whereas-clause-select').forEach(dropdown => {
                const selectedValue = dropdown.value; // Preserve selected value

                dropdown.innerHTML = ''; // Clear the current options

                // Add new options from the tags
                tags.forEach(tag => {
                    const opt = document.createElement('option');
                    opt.value = tag;
                    opt.innerText = tag;
                    dropdown.appendChild(opt);
                });

                // Restore the previously selected value if it exists in the updated options
                if (tags.includes(selectedValue)) {
                    dropdown.value = selectedValue;
                }
            });
        }

        const witnessethSectionTemplate = document.getElementById('witnesseth-section-preview').innerHTML;
        const witnessethSectionPreview = document.querySelector('.witnesseth-section-preview');
        const whereasClausesContainer = document.getElementById('whereas-clauses-container');
        const partnerAcronym = document.getElementById('partner_name').value;

        // Function to format the dropdown text with selective bolding
        function formatDropdownText(text) {
            if (text === 'the AUF') {
                return '<span class="bold">WHEREAS,</span> the <span class="bold">AUF</span>';
            } else if (text === `the AUF and ${partnerAcronym}`) {
                return `<span class="bold">WHEREAS,</span> the <span class="bold">AUF and ${partnerAcronym}</span>`;
            } else if (text === `the ${partnerAcronym}`) {
                return `<span class="bold">WHEREAS,</span> the <span class="bold">${partnerAcronym}</span>`;
            } else {
                return `<span class="bold">WHEREAS,</span> <span class="bold">${text}</span>`;
            }
        }

        // Function to update the introduction memorandum with all Whereas clauses
        function updateWitnessethSectionPreview() {
            const whereasItems = Array.from(document.querySelectorAll('.whereas-clause-item')).map(item => {
                const dropdown = item.querySelector('.whereas-clause-select');
                const textarea = item.querySelector('[name="whereas_clause_texts[]"]');
                const selectedValue = dropdown ? dropdown.value : '';
                const clauseText = textarea ? textarea.value.trim() : '';
                return clauseText ?
                    `<p class="indented-paragraph">${formatDropdownText(selectedValue)} ${clauseText}</p>` :
                    '';
            }).filter(clause => clause); // Filter out empty clauses

            // Format and update the introduction memorandum content
            witnessethSectionPreview.innerHTML = `
                ${witnessethSectionTemplate}
                ${whereasItems.join('')}
            `;
                                }
        // Attach input event listeners to dynamically added textareas and dropdowns for Whereas clauses
        whereasClausesContainer.addEventListener('input', function(e) {
            if (e.target.matches('[name="whereas_clause_texts[]"]') || e.target.matches(
                    '.whereas-clause-select')) {
                updateWitnessethSectionPreview();
            }
        });

        // Add another Whereas clause dynamically
        const addWhereasBtn = document.getElementById('add-whereas-clause-btn');
        addWhereasBtn.addEventListener('click', function() {
            // Create new Whereas clause container
            const newClauseDiv = document.createElement('div');
            newClauseDiv.classList.add('form-group', 'whereas-clause-item');

            // Add label for Whereas
            const newLabel = document.createElement('label');
            newLabel.innerText = 'Whereas,';
            newClauseDiv.appendChild(newLabel);

            // Create dropdown for Whereas clause options
            const newSelect = document.createElement('select');
            newSelect.classList.add('form-control', 'whereas-clause-select');
            newSelect.setAttribute('name', 'whereas_clauses[]');

            // Populate the new dropdown with options from tags
            tags.forEach(tag => {
                const newOption = document.createElement('option');
                newOption.value = tag;
                newOption.innerText = tag;
                newSelect.appendChild(newOption);
            });

            // Add textarea for the clause content
            const newTextarea = document.createElement('textarea');
            newTextarea.classList.add('form-control', 'mt-2');
            newTextarea.setAttribute('name', 'whereas_clause_texts[]');
            newTextarea.setAttribute('placeholder', 'Enter full Whereas Clause');
            newTextarea.required = true;

            // Add a "Remove" button for the clause
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.classList.add('btn', 'btn-danger', 'mt-2');
            removeBtn.innerText = 'Remove';
            removeBtn.addEventListener('click', function() {
                newClauseDiv.remove();
                updateWitnessethSectionPreview(); // Update memorandum after removing clause
            });

            // Append the new select, textarea, and remove button to the new clause div
            newClauseDiv.appendChild(newSelect);
            newClauseDiv.appendChild(newTextarea);
            newClauseDiv.appendChild(removeBtn);

            // Append the new clause div to the container
            document.getElementById('whereas-clauses-container').appendChild(newClauseDiv);
        });

        function setupArticleHandlers(articleNumber) {
        // Selectors for the elements
        const templateElement = document.getElementById(`article${articleNumber}-preview`);
        if (!templateElement) return; // Check if the template element exists
        const templateContent = templateElement.innerHTML;
        const previewElement = document.querySelector(`.article${articleNumber}-preview`);
        const containerElement = document.getElementById(`article${articleNumber}MenuContainer`);
        const addButton = document.getElementById(`add-article${articleNumber}-btn`);

        // Format duration text for ARTICLE 15 and Update Hidden Input
        const combinedDurationInput = document.getElementById('combined-duration');
        function getDurationText() {
                const durationValue = durationInput?.value || '0';
                const timeUnit = timeUnitDropdown?.value || 'Day';
                const combineDuration = `${durationValue} ${timeUnit}${durationValue > 1 ? 's' : ''}`
                combinedDurationInput.value = combineDuration
                return `${durationValue} ${timeUnit}${durationValue > 1 ? 's' : ''}`;
        }

        // Function to update the preview with entry texts
        function updateArticlePreview() {
            const articleItems = Array.from(containerElement.querySelectorAll(`.article${articleNumber}Item`)).map((item, index) => {
                const textarea = item.querySelector(`[name="article${articleNumber}[]"]`);
                const clauseText = textarea ? textarea.value.trim() : '';
                if (!clauseText) return ''; // Skip empty clauses

                // Custom numbering logic for articles
                if (articleNumber === 1) {
                    // No leading number for article 1 entries
                    return `<p class="indented-paragraph">${clauseText}</p>`;
                } else if (articleNumber === 2) {
                    // Number format for article 2: "2.2.1", "2.2.2", etc.
                    return `<p class="numbered-paragraphChild">2.2.${index + 1}. ${clauseText}</p>`;
                } else if (articleNumber === 7) {
                    return `<p class="numbered-paragraph">7.${6 + index}. ${clauseText}</p>`;
                } else if (articleNumber === 20){
                    return `<p class="numbered-paragraph">${articleNumber}.${4 + index}. ${clauseText}</p>`;
                } else if ([9,10,11].includes(articleNumber)) {
                    return `<p class="numbered-paragraph">${articleNumber}.${3 + index}. ${clauseText}</p>`;
                } else if ([12,13,14,15,16,17,18,19,21].includes(articleNumber)) {
                    return `<p class="numbered-paragraph">${articleNumber}.${2 + index}. ${clauseText}</p>`;
                } else {
                    // General format for other articles if needed
                    return `<p class="numbered-paragraph">${articleNumber}.${index + 1}. ${clauseText}</p>`;
                }
            }).filter(clause => clause); // Filter out empty clauses

            // If ARTICLE 15, replace [DURATION] with the formatted text
            const updatedTemplateContent = articleNumber === 15
                ? templateContent.replaceAll('[DURATION]', getDurationText())
                : templateContent;

            // Update the preview content
            previewElement.innerHTML = `
                ${updatedTemplateContent}
                ${articleItems.join('')}
            `;
        }

        // Attach input event listeners to dynamically added textareas for updating the preview
        containerElement.addEventListener('input', function (e) {
            if (e.target.matches(`[name="article${articleNumber}[]"]`)) {
                updateArticlePreview();
            }
        });

        // Attach duration change listeners only for ARTICLE 15
        if (articleNumber === 15) {
            durationInput.addEventListener('input', updateArticlePreview);
            timeUnitDropdown.addEventListener('change', updateArticlePreview);
        }

        // Function to add a new entry dynamically
        addButton.addEventListener('click', function () {
            const newClauseDiv = document.createElement('div');
            newClauseDiv.classList.add('form-group', `article${articleNumber}Item`);

            // Add label for the entry
            const newLabel = document.createElement('label');
            newLabel.innerText = 'Entry';
            newClauseDiv.appendChild(newLabel);

            // Add textarea
            const newTextarea = document.createElement('textarea');
            newTextarea.classList.add('form-control', 'mt-2');
            newTextarea.setAttribute('name', `article${articleNumber}[]`);
            newTextarea.setAttribute('placeholder', 'Enter text here.');
            newTextarea.required = true;

            // Add a "Remove" button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.classList.add('btn', 'btn-danger', 'mt-2');
            removeBtn.innerText = 'Remove';
            removeBtn.addEventListener('click', function () {
                newClauseDiv.remove();
                updateArticlePreview(); // Update preview after removing a clause
            });

            // Append textarea and remove button to the clause div
            newClauseDiv.appendChild(newTextarea);
            newClauseDiv.appendChild(removeBtn);

            // Append the new clause div to the container
            containerElement.appendChild(newClauseDiv);
        });

// Set up remove functionality for hardcoded items as well
containerElement.querySelectorAll(`.article${articleNumber}Item .btn-danger`).forEach(button => {
        button.addEventListener('click', function () {
            const articleItem = button.closest(`.article${articleNumber}Item`);
            if (articleItem) {
                articleItem.remove();
                updateArticlePreview();
            }
        });
    });

        // Initial preview update
        updateArticlePreview();
    }

    

    // Setup handlers for multiple articles
    for (let i = 1; i <= 21; i++) { // Adjust the number range as needed
        setupArticleHandlers(i);
    }

    });

    document.addEventListener('DOMContentLoaded', function() {
        const steps = [
            {
                id: 'step-0',
                header: 'Step 0: Introduction',
                optionsContainerId: 'article0Menu'
            },
            {
                id: 'step-1',
                header: 'Step 1: Witnesseth Section',
                optionsContainerId: 'whereas-section-options'
            },
            {
                id: 'step-2',
                header: 'Step 2: Program Overview',
                optionsContainerId: 'article1Menu'
            },
            {
                id: 'step-3',
                header: 'Step 3: Representation and Warranties',
                optionsContainerId: 'article2Menu'
            },
            {
                id: 'step-4',
                header: 'Step 4: Scope of Collaboration',
                optionsContainerId: 'article3Menu'
            },
            {
                id: 'step-5',
                header: 'Step 5: Responsibilities of <?php echo $link->proposalForm->institution_name_acronym; ?>',
                optionsContainerId: 'article5Menu'
            },
            {
                id: 'step-6',
                header: 'Step 6: Responsibilities of AUF and <?php echo $link->proposalForm->institution_name_acronym; ?>',
                optionsContainerId: 'article6Menu'
            },
            {
                id: 'step-7',
                header: 'Step 7: Intellectual Property Rights',
                optionsContainerId: 'article7Menu'
            },
            {
                id: 'step-8',
                header: 'Step 8: Employment Relations',
                optionsContainerId: 'article8Menu'
            },
            {
                id: 'step-9',
                header: 'Step 9: Exclusivity',
                optionsContainerId: 'article9Menu'
            },
            {
                id: 'step-10',
                header: 'Step 10: Material Adverse Change Clause',
                optionsContainerId: 'article10Menu'
            },
            {
                id: 'step-11',
                header: 'Step 11: Confidentiality',
                optionsContainerId: 'article11Menu'
            },
            {
                id: 'step-12',
                header: 'Step 12: Compliance with Law',
                optionsContainerId: 'article12Menu'
            },
            {
                id: 'step-13',
                header: 'Step 13: Non-Assignment of Rights',
                optionsContainerId: 'article13Menu'
            },
            {
                id: 'step-14',
                header: 'Step 14: Severability',
                optionsContainerId: 'article14Menu'
            },
            {
                id: 'step-15',
                header: 'Step 15: Effectivity',
                optionsContainerId: 'article15Menu'
            },
            {
                id: 'step-16',
                header: 'Step 16: Amendments',
                optionsContainerId: 'article16Menu'
            },
            {
                id: 'step-17',
                header: 'Step 17: Governing Law',
                optionsContainerId: 'article17Menu'
            },
            {
                id: 'step-18',
                header: 'Step 18: Dispute Resolution',
                optionsContainerId: 'article18Menu'
            },
            {
                id: 'step-19',
                header: 'Step 19: Dispute Resolution',
                optionsContainerId: 'article19Menu'
            },
            {
                id: 'step-20',
                header: 'Step 20: Notices',
                optionsContainerId: 'article20Menu'
            },
            {
                id: 'step-21',
                header: 'Step 21: Subsequent Agreements',
                optionsContainerId: 'article21Menu'
            }
            // Add more steps here as needed
        ];

        let currentStepIndex = 0;
        const navigationHeader = document.getElementById('section-navigation-header');
        const sectionNavigator = document.getElementById('section-navigator');
        const nextStepBtn = document.getElementById('next-step');
        const previousStepBtn = document.getElementById('previous-step');
        const submitBtn = document.getElementById('submit-form');

        // Update visibility of buttons and option containers based on current step
        function updateButtonVisibility() {
            previousStepBtn.style.display = currentStepIndex === 0 ? 'none' : 'block';
            nextStepBtn.style.display = currentStepIndex === steps.length - 1 ? 'none' : 'block';
            submitBtn.style.display = currentStepIndex === steps.length - 1 ? 'block' : 'none';

            // Show only the options container relevant to the current step
            steps.forEach((step, index) => {
                const optionsContainer = document.getElementById(step.optionsContainerId);
                if (optionsContainer) {
                    optionsContainer.style.display = currentStepIndex === index ? 'block' : 'none';
                }
            });
        }

        // Show the current step and update the navigation header
        function showStep(index) {
            document.querySelectorAll('.form-section').forEach(section => section.classList.add('hidden'));
            document.getElementById(steps[index].id).classList.remove('hidden');
            navigationHeader.textContent = steps[index].header;
            sectionNavigator.value = steps[index].id;
            updateButtonVisibility();
        }

        // Handle dropdown navigation
        sectionNavigator.addEventListener('change', function() {
            const selectedStepIndex = steps.findIndex(step => step.id === this.value);
            if (selectedStepIndex !== -1) {
                currentStepIndex = selectedStepIndex;
                showStep(currentStepIndex);
            }
        });

        // Event listener for the Next button
        nextStepBtn.addEventListener('click', function() {
            if (currentStepIndex < steps.length - 1) {
                currentStepIndex++;
                showStep(currentStepIndex);
            }
        });

        // Event listener for the Previous button
        previousStepBtn.addEventListener('click', function() {
            if (currentStepIndex > 0) {
                currentStepIndex--;
                showStep(currentStepIndex);
            }
        });

        // Populate the section navigator dropdown based on the steps array
        steps.forEach(step => {
            const option = document.createElement('option');
            option.value = step.id;
            option.textContent = step.header;
            sectionNavigator.appendChild(option);
        });

        // Initial setup to show the first step
        showStep(currentStepIndex);
    });

</script>
@endsection
