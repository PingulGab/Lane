@extends('layouts.nonAdmin')

@section('title', 'LANE - Dashboard')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$link->proposal_form_fk)
        <style>
            .sticky {
                position: sticky;
                top: 50%;
            }

            label {
                display: block;
            }
        
            /* General Table Styling */
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
            }
        
            /* Header row styling */
            th, td {
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
                font-size: 14px;
            }
        
            /* Subheaders with merged cells */
            .subheader {
                font-weight: bold;
                vertical-align: top;
                text-align: left;
                width: 20%;
                font-size: 14px;
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
                font-size: 21px;
            }
            
            textarea {
                width: 100%;
            }
        </style>
        <!--- Proposal Form --->
        <form method="POST" action="{{ route('submitProspectPartnerFormProposal', $link->link) }}" id="memorandum_form_id">
            @csrf

            <h1> Proposal Form </h1>
            <div class="twocol-container">
                <div class="twocol-container-area1">
                    <div class="proposal_form_group">
                        <div class="part1">
                            <table>
                                <!-- Part 1 -->
                                <tr>
                                    <th colspan="7" class="part-title">PART I. INSTITUTION’S BACKGROUND</th>
                                </tr>
                            
                                <tr>
                                    <td class="section-title" colspan="1">NAME OF THE INSTITUTION</td>
                                    <td colspan="6"><input type="text" name="institution_name" placeholder="Institution Name" required></td>
                                </tr>
                            
                                <tr>
                                    <td class="section-title" colspan="1">ACRONYM OF THE INSTITUTION</td>
                                    <td colspan="6"><input type="text" name="institution_name_acronym" placeholder="Institution Acronym" required></td>
                                </tr>
                            
                                <tr>
                                    <td class="section-title" colspan="1">HEAD OF THE INSTITUTION & THEIR TITLE</td>
                                    <td colspan="1"><input type="text" name="institution_head" placeholder="Institution's Head" required></td>
                                    <td colspan="5"><input type="text" name="institution_head_title" placeholder="President, CEO, Chairman" required></td>
                                </tr>
                            
                                <tr>
                                    <td class="section-title" colspan="1">COUNTRY</td>
                                    <td colspan="6">
                                        <select name="country" id="country" required>
                                            @foreach ($countriesList as $code => $name)
                                                <option value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            
                                <tr>
                                    <td class="section-title" colspan="1">TYPE OF INSTITUTION</td>
                                    <td colspan="6">
                                        <select name="type_of_institution" id="type_of_institution" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="Private Higher Educational Institution">Private Higher Educational Institution</option>
                                            <option value="Public Higher Educational Institution">Public Higher Educational Institution</option>
                                            <option value="Private Company">Private Company</option>
                                            <option value="Public Company">Public Company</option>
                                            <option value="Organization">Organization</option>
                                            <option value="Government Agency">Government Agency</option>
                                        </select>
                                    </td>
                                </tr>
                            
                                <!-- Contact Information -->
                                <tr>
                                    <td class="section-title" rowspan="5" colspan="1">CONTACT INFORMATION OF INSTITUTION</td>
                                </tr>
                                <tr>
                                    <td class="subheader" colspan="1">EMAIL ADDRESS</td>
                                    <td colspan="5"><input type="email" name="email" placeholder="Email" required></td>
                                </tr>
                                <tr>
                                    <td class="subheader" colspan="1">TELEPHONE NO.</td>
                                    <td colspan="5"><input type="text" name="telephone_number" placeholder="Telephone Number"></td>
                                </tr>
                                <tr>
                                    <td class="subheader" colspan="1">MOBILE NO.</td>
                                    <td colspan="5"><input type="text" name="mobile_number" placeholder="Mobile Number"></td>
                                </tr>
                                <tr>
                                    <td class="subheader" colspan="1">WEBSITE</td>
                                    <td colspan="5"><input type="text" name="website" placeholder="Website"></td>
                                </tr>
        
                                <tr>
                                    <td class="section-title" colspan="1">ADDRESS</td>
                                    <td colspan="6"><input type="text" name="address" placeholder="Address" required></td>
                                </tr>
                            
                                <!-- Overview of the Institution -->
                                <tr>
                                    <td class="section-title" colspan="1">OVERVIEW OF THE INSTITUTION</td>
                                    <td colspan="6"><textarea name="institution_overview" placeholder="Overview of Institution" required></textarea></td>
                                </tr>
                            
                                <!-- Local & International Accreditation -->
                                <tr>
                                    <td class="section-title" colspan="1" rowspan="1">LOCAL & INTERNATIONAL ACCREDITATION</td>
                                    <td colspan="5" id="accreditation">
                                        <div >
                                            <textarea class="form-control" name="accreditations[]"></textarea>
                                        </div>
                                    </td>
                                    <td colspan="1" style="width:10%;">
                                        <button type="button" id="add-accreditation-btn" class="btn btn-secondary">Add</button>
                                    </td>
                                </tr>
                            
                                <!-- Part II -->
                                <tr>
                                    <th colspan="7" class="part-title">PART II. INSTITUTION’S LINKAGES AND PARTNERS</th>
                                </tr>
        
                                <!-- Institution's Linkages and Partners Section -->
                                <tr>
                                    <td class="section-title" colspan="1">NAME OF INSTITUTION</td>
                                    <td class="section-title" colspan="2">NATURE OF PARTNERSHIP</td>
                                    <td class="section-title" colspan="3">VALIDITY PERIOD</td>
                                    <td class="section-title" colspan="1"> <button type="button" id="add_partner_linkages_btn" class="btn btn-secondary mt-3">+</button> </td>
                                </tr>
                                <tbody id="partner_linkages_container">
                                <tr>
                                    <div >
                                        <td colspan="1">
                                            <input type="text" name="partner_linkagess[0][institution_name]" placeholder="Institution Name">
                                        </td>
                                        <td colspan="2">
                                            <input type="text" name="partner_linkagess[0][nature_of_partnership]" placeholder="Nature of Partnership">
                                        </td>
                                        <td colspan="3">
                                            <input type="date" name="partner_linkagess[0][validity_period]" placeholder="Validity Period">
                                        </td>
                                        <td colspan="1">
                                            <button disabled> - </button>
                                        </td>
                                    </div>
                                </tr>
                                </tbody>
                            
                                <!-- Part III -->
                                <tr>
                                    <th colspan="7" class="part-title">PART III. PROPOSED PARTNERSHIP</th>
                                </tr>
        
                                <!-- Target Participant & Level -->
                                <tbody>
                                    <tr>
                                        <td class="section-title" rowspan="3">TARGET PARTICIPANT & LEVEL</td>
                                        
                                    </tr>
        
                                    <tr>
                                        <td colspan="6">
                                            <input type="radio" id="student" name="target_participant" value="Student" required> Student<br>
                                            <input type="radio" id="faculty" name="target_participant" value="Faculty" required> Faculty<br>
                                            <input type="radio" id="researcher" name="target_participant" value="Researcher" required> Researcher
                                        </td>
                                    </tr>
        
                                    <tr>
                                        <td colspan="1">
                                            <input type="radio" id="elementary" name="target_level" value="Elementary" required> Elementary<br>
                                            <input type="radio" id="junior_high_school" name="target_level" value="Junior High School" required> Junior High School<br>
                                            <input type="radio" id="senior_high_school" name="target_level" value="Senior High School" required> Senior High School
                                        </td>
                                        <td colspan="1">
                                            <input type="radio" id="undergraduate" name="target_level" value="Undergraduate" required> Undergraduate<br>
                                            <input type="radio" id="graduate_school" name="target_level" value="Graduate School" required> Graduate School
                                        </td>
                                        <td colspan="4">
                                            <input type="radio" id="esl" name="target_level" value="Certification Program (ESL)" required> Certification Program (ESL)
                                        </td>
                                    </tr>
                                </tbody>
        
                                <!-- Target Program or Course -->
                                <tr>
                                    <td class="section-title">TARGET PROGRAM OR COURSE:</td>
                                    <td colspan="6">
                                        <select name="selected_institutionalUnit" id="institutionalUnit" class="form-control" required>
                                            <option value="">Select an Institution</option>
                                            @foreach ($institutionalUnitList as $institutionalUnit)
                                                <option value="{{ $institutionalUnit->id }}">{{ $institutionalUnit->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
        
                                <tbody>
                                    <!-- Type of Partnership -->
                                    <tr>
                                        <td class="section-title" rowspan="5">TYPE OF PARTNERSHIP:</td>
                                    </tr>
                                    <tr>
                                        <td class="subheader" colspan="1">Non-Degree Program</td>
                                        <td colspan="5">
                                            <input type="radio" name="type_of_partnership" value="English as Second Language (ESL)" required> English as Second Language (ESL) <br>
                                            <input type="radio" name="type_of_partnership" value="Audit Class / Sit-in Class" required> Audit Class / Sit-in Class<br>
                                            <input type="radio" name="type_of_partnership" value="Study and Tour Program" required> Study and Tour Program<br>
                                            <input type="radio" name="type_of_partnership" value="Conference / Seminar" required> Conference / Seminar<br>
                                            <input type="radio" name="type_of_partnership" value="Non-Degree Program - Others" required id="non-degree-others"> Others
                                            <input type="text" id="non-degree-input" placeholder="Please specify" style="display: none;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="subheader" colspan="1">Degree Program</td>
                                        <td colspan="5">
                                            <input type="radio" name="type_of_partnership" value="Academic Franchising" required> Academic Franchising<br>
                                            <input type="radio" name="type_of_partnership" value="Program Articulation" required> Program Articulation<br>
                                            <input type="radio" name="type_of_partnership" value="Branch or International Campus" required> Branch or International Campus<br>
                                            <input type="radio" name="type_of_partnership" value="Double Degree" required> Double Degree<br>
                                            <input type="radio" name="type_of_partnership" value="Joint Degree" required> Joint Degree<br>
                                            <input type="radio" name="type_of_partnership" value="Online, Blended, and Distance Learning" required> Online, Blended, and Distance Learning<br>
                                            <input type="radio" name="type_of_partnership" value="Twinning Arrangements" required> Twinning Arrangements<br>
                                            <input type="radio" name="type_of_partnership" value="Degree Program - Others" required id="degree-others"> Others
                                            <input type="text" id="degree-input" placeholder="Please specify" style="display: none;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="subheader" colspan="1">Mobility Program</td>
                                        <td colspan="5">
                                            <input type="radio" name="type_of_partnership" value="Inbound Student" required> Inbound Student<br>
                                            <input type="radio" name="type_of_partnership" value="Outbound Student" required> Outbound Student<br>
                                            <input type="radio" name="type_of_partnership" value="Inbound Teacher" required> Inbound Teacher<br>
                                            <input type="radio" name="type_of_partnership" value="Outbound Teacher" required> Outbound Teacher<br>
                                            <input type="radio" name="type_of_partnership" value="Mobility Program - Others" required id="mobility-others"> Others
                                            <input type="text" id="mobility-input" placeholder="Please specify" style="display: none;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="subheader" colspan="1">Research Program</td>
                                        <td colspan="5">
                                            <input type="radio" name="type_of_partnership" value="Collaborative Research" required> Collaborative Research<br>
                                            <input type="radio" name="type_of_partnership" value="Capacity Building Program" required> Capacity Building Program<br><span class="instructions">(Research Training, Workshops, Mentorship, Secondment)</span><br>
                                            <input type="radio" name="type_of_partnership" value="Research Dissemination Program" required> Research Dissemination Program<br><span class="instructions">(Research Colloquium and Conferences; Publication Partnership with Indexed Journals)</span><br>
                                            <input type="radio" name="type_of_partnership" value="Research Utilization Program" required> Research Utilization Program<br><span class="instructions">(Research-based - Joint Policy Development, Product Development, and  Intellectual property)</span><br>
                                            <input type="radio" name="type_of_partnership" value="Research Program - Others" required id="research-others"> Others
                                            <input type="text" id="research-input" placeholder="Please specify" style="display: none;">
                                        </td>
                                    </tr>
                                </tbody>
        
                                <!-- Overview of the Proposed Partnership -->
                                <tr>
                                    <td class="section-title">OVERVIEW OF THE PROPOSED PARTNERSHIP:</td>
                                    <td colspan="7">
                                        <textarea class="partnership_overview" name="partnership_overview" placeholder="Overview of the Proposed Partnership" required></textarea>
                                    </td>
                                </tr>
        
                                <!-- Expected Outcomes of the Proposed Partnership -->
                                <tr>
                                    <td class="section-title">EXPECTED OUTCOMES FROM THE PROPOSED PARTNERSHIP:</td>
                                    <td colspan="7">
                                        <textarea class="partnership_expected_outcome" name="partnership_expected_outcome" placeholder="Expected Outcome of the Proposed Partnership" required></textarea>
                                    </td>
                                </tr>
        
                                <!-- Target Participants of the Proposed Partnership -->
                                <tr>
                                    <td class="section-title">TARGET PARTICIPANTS OF THE PROPOSED PARTNERSHIP:</td>
                                    <td colspan="7">
                                        <textarea class="partnership_target_participants" name="partnership_target_participants" placeholder="Target of the Proposed Partnership" required></textarea>
                                    </td>
                                </tr>
                                
                                <!-- Part IV -->
                                <tr>
                                    <th colspan="7" class="part-title">PART IV. CONTACT PERSON</th>
                                </tr>
                                <!-- Contact Person -->
                                <div>
                                    <tr>
                                        <td class="section-title" rowspan="6" colspan="1">CONTACT PERSON / LIAISON OFFICER</td>
                                        <td colspan="1" class="subheader">NAME</td>
                                        <td colspan="5"><input type="text" name="contact_person_name" placeholder="Name" required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="subheader">EMAIL ADDRESS</td>
                                        <td colspan="5"><input type="email" name="contact_person_email" placeholder="Email" required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="subheader">POSITION</td>
                                        <td colspan="5"><input type="text" name="contact_person_position" placeholder="Position" required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="subheader">OFFICE</td>
                                        <td colspan="5"><input type="text" name="contact_person_office" placeholder="Office" required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="subheader">TELEPHONE NUMBER</td>
                                        <td colspan="5"><input type="text" name="contact_person_telephone_number" placeholder="Telephone Number"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="subheader">MOBILE NUMBER</td>
                                        <td colspan="5"><input type="text" name="contact_person_mobile_number" placeholder="Mobile Number"></td>
                                    </tr>
                                </div>
                            </table>
                        </div>   
                    </div>
                </div>

                <div class="twocol-container-area2">
                    <div class="sticky">
                        <button type="submit" class="submit-btn" onclick="prepareSubmission()">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <!--- Script for Type of Partnership --->
        <script>
            document.getElementById('add-accreditation-btn').addEventListener('click', function() {
                const container = document.getElementById('accreditation');
                const newArticle = document.createElement('textarea');
                newArticle.classList.add('form-control', 'mt-2');
                newArticle.name = 'accreditations[]';
                newArticle.required = true;
                container.appendChild(newArticle);
            });

            document.getElementById('memorandum_form_id').addEventListener('submit', function() {
                const textareas = document.querySelectorAll('textarea[name="accreditations[]"]');
                textareas.forEach(textarea => {
                    if (textarea.value.trim() === '') {
                        textarea.remove(); // Remove empty textarea before submitting
                    }
                });
            });

            let partner_linkagesCount = 1; // To track number of partner_linkages forms

            document.getElementById('add_partner_linkages_btn').addEventListener('click', function() {
                // Create new partner_linkages form container
                const newPartner_LinkagesDiv = document.createElement('tr');
                newPartner_LinkagesDiv.classList.add('partner_linkages_form', 'mt-3');

                // Institution Name field
                const institutionDiv = document.createElement('td');
                institutionDiv.setAttribute('colspan', '1');
                const institutionLabel = document.createElement('label');
                institutionLabel.innerText = 'Institution Name';
                const institutionInput = document.createElement('input');
                institutionInput.type = 'text';
                institutionInput.name = `partner_linkagess[${partner_linkagesCount}][institution_name]`;
                institutionInput.placeholder = 'Institution Name';
                institutionInput.required = true;
                institutionDiv.appendChild(institutionLabel);
                institutionDiv.appendChild(institutionInput);

                // Nature of Partnership field
                const partnershipDiv = document.createElement('td');
                partnershipDiv.setAttribute('colspan', '2');
                const partnershipLabel = document.createElement('label');
                partnershipLabel.innerText = 'Nature of Partnership';
                const partnershipInput = document.createElement('input');
                partnershipInput.type = 'text';
                partnershipInput.name = `partner_linkagess[${partner_linkagesCount}][nature_of_partnership]`;
                partnershipInput.placeholder = 'Nature of Partnership';
                partnershipInput.required = true;
                partnershipDiv.appendChild(partnershipLabel);
                partnershipDiv.appendChild(partnershipInput);

                // Validity Period field
                const validityDiv = document.createElement('td');
                validityDiv.setAttribute('colspan', '3');
                const validityLabel = document.createElement('label');
                validityLabel.innerText = 'Validity Period';
                const validityInput = document.createElement('input');
                validityInput.type = 'date';
                validityInput.name = `partner_linkagess[${partner_linkagesCount}][validity_period]`;
                validityInput.required = true;
                validityDiv.appendChild(validityLabel);
                validityDiv.appendChild(validityInput);

                // Remove button
                const removeDiv = document.createElement('td');
                removeDiv.setAttribute('colspan', '1');
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.classList.add('btn', 'btn-danger', 'mt-2');
                removeBtn.innerText = '-';
                removeBtn.addEventListener('click', function() {
                    newPartner_LinkagesDiv.remove();
                });
                removeDiv.appendChild(removeBtn);

                // Append elements to the new partner_linkages form container
                newPartner_LinkagesDiv.appendChild(institutionDiv);
                newPartner_LinkagesDiv.appendChild(partnershipDiv);
                newPartner_LinkagesDiv.appendChild(validityDiv);
                newPartner_LinkagesDiv.appendChild(removeDiv);

                // Append the new partner_linkages form container to the main container
                document.getElementById('partner_linkages_container').appendChild(newPartner_LinkagesDiv);

                // Increment partner_linkages count
                partner_linkagesCount++;
            });

             // Function to handle showing/hiding text input for "Others" and updating value
            function setupOthersOption(radioId, inputId, categoryName) {
                const radioButton = document.getElementById(radioId);
                const textInput = document.getElementById(inputId);

                // Show input when "Others" is selected
                radioButton.addEventListener('change', function() {
                    if (radioButton.checked) {
                        textInput.style.display = 'inline-block';
                        textInput.required = true;
                    }
                });

                // Update radio button value with category and user input
                textInput.addEventListener('input', function() {
                    radioButton.value = `${categoryName} - ${textInput.value}`;
                });

                // Hide input and reset value when other options are selected
                document.querySelectorAll(`input[name="type_of_partnership"]`).forEach((radio) => {
                    if (radio !== radioButton) {
                        radio.addEventListener('change', function() {
                            textInput.style.display = 'none';
                            textInput.required = false;
                            textInput.value = '';
                            radioButton.value = `${categoryName} - Others`; // Reset value when deselected
                        });
                    }
                });
            }

            // Setup each category
            setupOthersOption('non-degree-others', 'non-degree-input', 'Non-Degree Program');
            setupOthersOption('degree-others', 'degree-input', 'Degree Program');
            setupOthersOption('mobility-others', 'mobility-input', 'Mobility Program');
            setupOthersOption('research-others', 'research-input', 'Research Program');
        </script>
    @elseif($link->proposal_form_fk)
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
                                <input type="text" class="form-control" name="partnership_title" id="partnership_title" placeholder="" required>
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
                                <div class="form-group article1Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article1[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article2Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article2[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article3Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article3[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article5Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article5[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article6Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article6[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article7Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article7[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article8Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article8[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article9Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article9[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article10Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article10[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article11Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article11[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article12Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article12[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article13Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article13[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article14Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article14[]" placeholder="Enter text here." required></textarea>
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
                                <input type="number" class="form-control" id="durationInput" placeholder="Enter number" min="1" required>
                            </div>
                            <div class="form-group">
                                <label>Time Unit:</label>
                                <select class="form-control" id="timeUnitDropdown">
                                    <option value="day">Day</option>
                                    <option value="month">Month</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>

                            <input type="hidden" name="combined_duration" id="combined-duration">

                            <!-- Program Overview Container -->
                            <div id="article15MenuContainer">
                                <small class="error-message text-danger" id="article15ErrorMessage"></small>
                                <!-- First Entry -->
                                <div class="form-group article15Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article15[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article16Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article16[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article17Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article17[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article18Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article18[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article19Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article19[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article20Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article20[]" placeholder="Enter text here." required></textarea>
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
                                <div class="form-group article21Item">
                                    <label>Entry</label>
                                    <textarea class="form-control" name="article21[]" placeholder="Enter text here." required></textarea>
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
    @endif

@endsection
