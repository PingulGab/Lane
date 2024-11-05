@php
    $selected_type_of_partnership = $link->proposalForm->type_of_partnership;
@endphp

@extends('layouts.Nonadmin')

@section('content')
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
<form method="POST" action="{{ route('partnerEditProposal', $link->link) }}" id="memorandum_form_id">
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
                            <td colspan="6"><input type="text" name="institution_name" placeholder="Institution Name" value="{{$proposal->institution_name}}" required></td>
                        </tr>
                    
                        <tr>
                            <td class="section-title" colspan="1">ACRONYM OF THE INSTITUTION</td>
                            <td colspan="6"><input type="text" name="institution_name_acronym" placeholder="Institution Acronym" required value="{{$proposal->institution_name_acronym}}"></td>
                        </tr>
                    
                        <tr>
                            <td class="section-title" colspan="1">HEAD OF THE INSTITUTION & THEIR TITLE</td>
                            <td colspan="1"><input type="text" name="institution_head" placeholder="Institution's Head" required value="{{$proposal->institution_head}}"></td>
                            <td colspan="5"><input type="text" name="institution_head_title" placeholder="President, CEO, Chairman" required value="{{$proposal->institution_head_title}}"></td>
                        </tr>
                    
                        <tr>
                            <td class="section-title" colspan="1">COUNTRY</td>
                            <td colspan="6">
                                <select name="country" id="country" required>
                                    @foreach ($countriesList as $code => $name)
                                        <option value="{{ $name }}" 
                                            @if ($name == $proposal->country) selected @endif>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    
                        <tr>
                            <td class="section-title" colspan="1">TYPE OF INSTITUTION</td>
                            <td colspan="6">
                                <select name="type_of_institution" id="type_of_institution" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="Private Higher Educational Institution" 
                                        @if ($proposal->type_of_institution == 'Private Higher Educational Institution') selected @endif>
                                        Private Higher Educational Institution
                                    </option>
                                    <option value="Public Higher Educational Institution" 
                                        @if ($proposal->type_of_institution == 'Public Higher Educational Institution') selected @endif>
                                        Public Higher Educational Institution
                                    </option>
                                    <option value="Private Company" 
                                        @if ($proposal->type_of_institution == 'Private Company') selected @endif>
                                        Private Company
                                    </option>
                                    <option value="Public Company" 
                                        @if ($proposal->type_of_institution == 'Public Company') selected @endif>
                                        Public Company
                                    </option>
                                    <option value="Organization" 
                                        @if ($proposal->type_of_institution == 'Organization') selected @endif>
                                        Organization
                                    </option>
                                    <option value="Government Agency" 
                                        @if ($proposal->type_of_institution == 'Government Agency') selected @endif>
                                        Government Agency
                                    </option>
                                </select>
                            </td>
                        </tr>
                    
                        <!-- Contact Information -->
                        <tr>
                            <td class="section-title" rowspan="5" colspan="1">CONTACT INFORMATION OF INSTITUTION</td>
                        </tr>
                        <tr>
                            <td class="subheader" colspan="1">EMAIL ADDRESS</td>
                            <td colspan="5"><input type="email" name="email" placeholder="Email" required value="{{$proposal->email}}"></td>
                        </tr>
                        <tr>
                            <td class="subheader" colspan="1">TELEPHONE NO.</td>
                            <td colspan="5"><input type="text" name="telephone_number" placeholder="Telephone Number" value="{{$proposal->telephone_number}}"></td>
                        </tr>
                        <tr>
                            <td class="subheader" colspan="1">MOBILE NO.</td>
                            <td colspan="5"><input type="text" name="mobile_number" placeholder="Mobile Number" value="{{$proposal->mobile_number}}"></td>
                        </tr>
                        <tr>
                            <td class="subheader" colspan="1">WEBSITE</td>
                            <td colspan="5"><input type="text" name="website" placeholder="Website" value="{{$proposal->website}}"></td>
                        </tr>

                        <tr>
                            <td class="section-title" colspan="1">ADDRESS</td>
                            <td colspan="6"><input type="text" name="address" placeholder="Address" required value="{{$proposal->address}}"></td>
                        </tr>
                    
                        <!-- Overview of the Institution -->
                        <tr>
                            <td class="section-title" colspan="1">OVERVIEW OF THE INSTITUTION</td>
                            <td colspan="6"><textarea name="institution_overview" placeholder="Overview of Institution" required>{{$proposal->institution_overview}}</textarea></td>
                        </tr>
                    
                        <!-- Local & International Accreditation -->
                        <tr>
                            <td class="section-title" colspan="1" rowspan="1">LOCAL & INTERNATIONAL ACCREDITATION</td>
                            <td colspan="5" id="accreditation_container">
                                <div>
                                    @if(!empty($proposal->institution_accreditation) && json_decode($proposal->institution_accreditation))
                                        @foreach (json_decode($proposal->institution_accreditation) as $index => $article)
                                            <div class="form-group accreditation-item">
                                                    <div style="display: flex;">
                                                    <textarea class="form-control" name="accreditations[]" style="width: 90%" required>{{ $article }}</textarea>
                                                    <button type="button" class="btn btn-danger remove-accreditation-btn mt-2">-</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Empty textarea when there is no accreditation data -->
                                        <div class="form-group accreditation-item">
                                            <textarea class="form-control" name="accreditations[]"></textarea>
                                        </div>
                                    @endif
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
                            @if($proposal->partnerLinkages->isEmpty())
                                <!-- If no partner linkages, render one empty row -->
                                <tr>
                                    <td colspan="1">
                                        <input type="text" name="partner_linkagess[0][institution_name]" 
                                            value="{{ old('partner_linkagess.0.institution_name') }}" 
                                            placeholder="Institution Name">
                                    </td>
                                    <td colspan="2">
                                        <input type="text" name="partner_linkagess[0][nature_of_partnership]" 
                                            value="{{ old('partner_linkagess.0.nature_of_partnership') }}" 
                                            placeholder="Nature of Partnership">
                                    </td>
                                    <td colspan="3">
                                        <input type="date" name="partner_linkagess[0][validity_period]" 
                                            value="{{ old('partner_linkagess.0.validity_period') }}" 
                                            placeholder="Validity Period">
                                    </td>
                                    <td colspan="1">
                                        <button type="button" class="btn btn-danger remove-clause-btn mt-2">-</button>
                                    </td>
                                </tr>
                            @else
                                <!-- If there are partner linkages, render them -->
                                @foreach ($proposal->partnerLinkages as $index => $partnerLinkage)
                                    <tr>
                                        <td colspan="1">
                                            <input type="text" name="partner_linkagess[{{ $index }}][institution_name]" 
                                                value="{{ old('partner_linkagess.' . $index . '.institution_name', $partnerLinkage->institution_name) }}" 
                                                placeholder="Institution Name">
                                        </td>
                                        <td colspan="2">
                                            <input type="text" name="partner_linkagess[{{ $index }}][nature_of_partnership]" 
                                                value="{{ old('partner_linkagess.' . $index . '.nature_of_partnership', $partnerLinkage->nature_of_partnership) }}" 
                                                placeholder="Nature of Partnership">
                                        </td>
                                        <td colspan="3">
                                            <input type="date" name="partner_linkagess[{{ $index }}][validity_period]" 
                                                value="{{ old('partner_linkagess.' . $index . '.validity_period', $partnerLinkage->validity_period) }}" 
                                                placeholder="Validity Period">
                                        </td>
                                        <td colspan="1">
                                            <button type="button" class="btn btn-danger remove-clause-btn mt-2">-</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
                                    <input type="radio" id="student" name="target_participant" value="Student" 
                                        @if ($proposal->target_participant == 'Student') checked @endif 
                                        required> Student<br>
                                    
                                    <input type="radio" id="faculty" name="target_participant" value="Faculty" 
                                        @if ($proposal->target_participant == 'Faculty') checked @endif 
                                        required> Faculty<br>
                                    
                                    <input type="radio" id="researcher" name="target_participant" value="Researcher" 
                                        @if ($proposal->target_participant == 'Researcher') checked @endif 
                                        required> Researcher
                                </td>                                
                            </tr>

                            <tr>
                                <td colspan="1">
                                    <input type="radio" id="elementary" name="target_level" value="Elementary" 
                                        @if ($proposal->target_level == 'Elementary') checked @endif 
                                        required> Elementary<br>
                            
                                    <input type="radio" id="junior_high_school" name="target_level" value="Junior High School" 
                                        @if ($proposal->target_level == 'Junior High School') checked @endif 
                                        required> Junior High School<br>
                            
                                    <input type="radio" id="senior_high_school" name="target_level" value="Senior High School" 
                                        @if ($proposal->target_level == 'Senior High School') checked @endif 
                                        required> Senior High School
                                </td>
                            
                                <td colspan="1">
                                    <input type="radio" id="undergraduate" name="target_level" value="Undergraduate" 
                                        @if ($proposal->target_level == 'Undergraduate') checked @endif 
                                        required> Undergraduate<br>
                            
                                    <input type="radio" id="graduate_school" name="target_level" value="Graduate School" 
                                        @if ($proposal->target_level == 'Graduate School') checked @endif 
                                        required> Graduate School
                                </td>
                            
                                <td colspan="4">
                                    <input type="radio" id="esl" name="target_level" value="Certification Program (ESL)" 
                                        @if ($proposal->target_level == 'Certification Program (ESL)') checked @endif 
                                        required> Certification Program (ESL)
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
                                        <option value="{{ $institutionalUnit->id }}" 
                                            @if ($institutionalUnit->id == $proposal->institutional_unit_id) selected @endif>
                                            {{ $institutionalUnit->name }}
                                        </option>
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
                                    <input type="radio" name="type_of_partnership" value="English as Second Language (ESL)" 
                                        @if ($proposal->type_of_partnership == 'English as Second Language (ESL)') checked @endif
                                        required> English as Second Language (ESL) <br>
                        
                                    <input type="radio" name="type_of_partnership" value="Audit Class / Sit-in Class" 
                                        @if ($proposal->type_of_partnership == 'Audit Class / Sit-in Class') checked @endif
                                        required> Audit Class / Sit-in Class<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Study and Tour Program" 
                                        @if ($proposal->type_of_partnership == 'Study and Tour Program') checked @endif
                                        required> Study and Tour Program<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Conference / Seminar" 
                                        @if ($proposal->type_of_partnership == 'Conference / Seminar') checked @endif
                                        required> Conference / Seminar<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Non-Degree Program - Others"
                                    id="non-degree-others" <?php echo strpos($selected_type_of_partnership, 'Non-Degree Program - ') === 0 ? 'checked' : ''; ?>>
                                    Others
                
                                    <!-- Show the input box only if 'Others' was selected -->
                                    <input type="text" id="non-degree-input" name="non_degree_other_value"
                                        placeholder="Please specify" value="<?php echo strpos($selected_type_of_partnership, 'Non-Degree Program - ') === 0 ? substr($selected_type_of_partnership, 18) : ''; ?>" style="<?php echo strpos($proposal->type_of_partnership, 'Non-Degree Program - ') === 0 ? '' : 'display: none;'; ?>"
                                        >
                                </td>
                            </tr>
                            <tr>
                                <td class="subheader" colspan="1">Degree Program</td>
                                <td colspan="5">
                                    <input type="radio" name="type_of_partnership" value="Academic Franchising" 
                                        @if ($proposal->type_of_partnership == 'Academic Franchising') checked @endif
                                        required> Academic Franchising<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Program Articulation" 
                                        @if ($proposal->type_of_partnership == 'Program Articulation') checked @endif
                                        required> Program Articulation<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Branch or International Campus" 
                                        @if ($proposal->type_of_partnership == 'Branch or International Campus') checked @endif
                                        required> Branch or International Campus<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Double Degree" 
                                        @if ($proposal->type_of_partnership == 'Double Degree') checked @endif
                                        required> Double Degree<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Joint Degree" 
                                        @if ($proposal->type_of_partnership == 'Joint Degree') checked @endif
                                        required> Joint Degree<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Online, Blended, and Distance Learning" 
                                        @if ($proposal->type_of_partnership == 'Online, Blended, and Distance Learning') checked @endif
                                        required> Online, Blended, and Distance Learning<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Twinning Arrangements" 
                                        @if ($proposal->type_of_partnership == 'Twinning Arrangements') checked @endif
                                        required> Twinning Arrangements<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Degree Program - Others"
                                    id="degree-others" <?php echo strpos($selected_type_of_partnership, 'Degree Program - ') === 0 ? 'checked' : ''; ?>>
                                    Others
                
                                    <!-- Show the input box only if 'Others' was selected -->
                                    <input type="text" id="degree-input" name="degree_other_value" placeholder="Please specify"
                                        value="<?php echo strpos($selected_type_of_partnership, 'Degree Program - ') === 0 ? substr($selected_type_of_partnership, 15) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Degree Program - ') === 0 ? '' : 'display: none;'; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="subheader" colspan="1">Mobility Program</td>
                                <td colspan="5">
                                    <input type="radio" name="type_of_partnership" value="Inbound Student" 
                                        @if ($proposal->type_of_partnership == 'Inbound Student') checked @endif
                                        required> Inbound Student<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Outbound Student" 
                                        @if ($proposal->type_of_partnership == 'Outbound Student') checked @endif
                                        required> Outbound Student<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Inbound Teacher" 
                                        @if ($proposal->type_of_partnership == 'Inbound Teacher') checked @endif
                                        required> Inbound Teacher<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Outbound Teacher" 
                                        @if ($proposal->type_of_partnership == 'Outbound Teacher') checked @endif
                                        required> Outbound Teacher<br>
                        
                                        <input type="radio" name="type_of_partnership" value="Mobility Program - Others"
                                        id="mobility-others" <?php echo strpos($selected_type_of_partnership, 'Mobility Program - ') === 0 ? 'checked' : ''; ?>>
                                    Others
                
                                    <!-- Show the input box only if 'Others' was selected -->
                                    <input type="text" id="mobility-input" name="degree_other_value" placeholder="Please specify"
                                        value="<?php echo strpos($selected_type_of_partnership, 'Mobility Program - ') === 0 ? substr($selected_type_of_partnership, 18) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Mobility Program - ') === 0 ? '' : 'display: none;'; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="subheader" colspan="1">Research Program</td>
                                <td colspan="5">
                                    <input type="radio" name="type_of_partnership" value="Collaborative Research" 
                                        @if ($proposal->type_of_partnership == 'Collaborative Research') checked @endif
                                        required> Collaborative Research<br>
                        
                                    <input type="radio" name="type_of_partnership" value="Capacity Building Program" 
                                        @if ($proposal->type_of_partnership == 'Capacity Building Program') checked @endif
                                        required> Capacity Building Program<br><span class="instructions">(Research Training, Workshops, Mentorship, Secondment)</span><br>
                        
                                    <input type="radio" name="type_of_partnership" value="Research Dissemination Program" 
                                        @if ($proposal->type_of_partnership == 'Research Dissemination Program') checked @endif
                                        required> Research Dissemination Program<br><span class="instructions">(Research Colloquium and Conferences; Publication Partnership with Indexed Journals)</span><br>
                        
                                    <input type="radio" name="type_of_partnership" value="Research Utilization Program" 
                                        @if ($proposal->type_of_partnership == 'Research Utilization Program') checked @endif
                                        required> Research Utilization Program<br><span class="instructions">(Research-based - Joint Policy Development, Product Development, and Intellectual property)</span><br>
                        
                                        <input type="radio" name="type_of_partnership" value="Research Program - Others"
                                        id="research-others" <?php echo strpos($selected_type_of_partnership, 'Research Program - ') === 0 ? 'checked' : ''; ?>>
                                    Others
                
                                    <!-- Show the input box only if 'Others' was selected -->
                                    <input type="text" id="research-input" name="degree_other_value" placeholder="Please specify"
                                        value="<?php echo strpos($selected_type_of_partnership, 'Research Program - ') === 0 ? substr($selected_type_of_partnership, 17) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Research Program - ') === 0 ? '' : 'display: none;'; ?>">
                                </td>
                            </tr>
                        </tbody>                        

                        <!-- Overview of the Proposed Partnership -->
                        <tr>
                            <td class="section-title">OVERVIEW OF THE PROPOSED PARTNERSHIP:</td>
                            <td colspan="7">
                                <textarea class="partnership_overview" name="partnership_overview" placeholder="Overview of the Proposed Partnership" required>{{$proposal->partnership_overview}}</textarea>
                            </td>
                        </tr>

                        <!-- Expected Outcomes of the Proposed Partnership -->
                        <tr>
                            <td class="section-title">EXPECTED OUTCOMES FROM THE PROPOSED PARTNERSHIP:</td>
                            <td colspan="7">
                                <textarea class="partnership_expected_outcome" name="partnership_expected_outcome" placeholder="Expected Outcome of the Proposed Partnership" required>{{$proposal->partnership_expected_outcome}}</textarea>
                            </td>
                        </tr>

                        <!-- Target Participants of the Proposed Partnership -->
                        <tr>
                            <td class="section-title">TARGET PARTICIPANTS OF THE PROPOSED PARTNERSHIP:</td>
                            <td colspan="7">
                                <textarea class="partnership_target_participants" name="partnership_target_participants" placeholder="Target of the Proposed Partnership" required>{{$proposal->partnership_target_participants}}</textarea>
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
                                <td colspan="5"><input type="text" name="contact_person_name" placeholder="Name" required value="{{$proposal->contactPerson->name}}"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="subheader">EMAIL ADDRESS</td>
                                <td colspan="5"><input type="email" name="contact_person_email" placeholder="Email" required value="{{$proposal->contactPerson->email}}"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="subheader">POSITION</td>
                                <td colspan="5"><input type="text" name="contact_person_position" placeholder="Position" required value="{{$proposal->contactPerson->position}}"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="subheader">OFFICE</td>
                                <td colspan="5"><input type="text" name="contact_person_office" placeholder="Office" required value="{{$proposal->contactPerson->office}}"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="subheader">TELEPHONE NUMBER</td>
                                <td colspan="5"><input type="text" name="contact_person_telephone_number" placeholder="Telephone Number" value="{{$proposal->contactPerson->telephone_number}}"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="subheader">MOBILE NUMBER</td>
                                <td colspan="5"><input type="text" name="contact_person_mobile_number" placeholder="Mobile Number" value="{{$proposal->contactPerson->mobile_number}}"></td>
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

    let partner_linkagesCount = document.querySelectorAll('#partner_linkages_container tr').length;
    let accreditationCount = document.querySelectorAll('#accreditation_container .accreditation-item').length;

    document.getElementById('add_partner_linkages_btn').addEventListener('click', function() {
        // Create new partner_linkages form container
        const newPartner_LinkagesDiv = document.createElement('tr');
        newPartner_LinkagesDiv.classList.add('partner_linkages_form', 'mt-3');

        // Institution Name field
        const institutionDiv = document.createElement('td');
        institutionDiv.setAttribute('colspan', '1');
        const institutionInput = document.createElement('input');
        institutionInput.type = 'text';
        institutionInput.name = `partner_linkagess[${partner_linkagesCount}][institution_name]`;
        institutionInput.placeholder = 'Institution Name';
        institutionInput.required = true;
        institutionDiv.appendChild(institutionInput);

        // Nature of Partnership field
        const partnershipDiv = document.createElement('td');
        partnershipDiv.setAttribute('colspan', '2');
        const partnershipInput = document.createElement('input');
        partnershipInput.type = 'text';
        partnershipInput.name = `partner_linkagess[${partner_linkagesCount}][nature_of_partnership]`;
        partnershipInput.placeholder = 'Nature of Partnership';
        partnershipInput.required = true;
        partnershipDiv.appendChild(partnershipInput);

        // Validity Period field
        const validityDiv = document.createElement('td');
        validityDiv.setAttribute('colspan', '3');
        const validityInput = document.createElement('input');
        validityInput.type = 'date';
        validityInput.name = `partner_linkagess[${partner_linkagesCount}][validity_period]`;
        validityInput.required = true;
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

    // Accreditation - Add and Remove functionality
    document.getElementById('add-accreditation-btn').addEventListener('click', function() {
        const accreditationContainer = document.createElement('div');
        accreditationContainer.classList.add('form-group', 'accreditation-item');
        accreditationContainer.style.display = 'flex';

        const accreditationTextarea = document.createElement('textarea');
        accreditationTextarea.style.cssText = "width: 90%";
        accreditationTextarea.classList.add('form-control');
        accreditationTextarea.name = 'accreditations[]';
        accreditationTextarea.required = true;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn', 'btn-danger', 'remove-accreditation-btn', 'mt-2');
        removeBtn.innerText = '-';
        removeBtn.addEventListener('click', function() {
            accreditationContainer.remove();
        });

        accreditationContainer.appendChild(accreditationTextarea);
        accreditationContainer.appendChild(removeBtn);

        document.getElementById('accreditation_container').appendChild(accreditationContainer);

        accreditationCount++;
    });

    // Add remove event listeners to pre-existing accreditation items
    document.querySelectorAll('#accreditation_container .accreditation-item').forEach(item => {
        const removeBtn = item.querySelector('.remove-accreditation-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                item.remove();
            });
        }
    });

    // Add remove event listeners to pre-existing rows generated by the loop
    document.querySelectorAll('#partner_linkages_container tr').forEach(row => {
            const removeBtn = row.querySelector('button');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    row.remove();
                });
            }
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
@endsection
