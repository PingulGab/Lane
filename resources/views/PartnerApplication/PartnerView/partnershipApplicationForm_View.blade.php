@extends('layouts.layout')

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

    <form method="POST" action="{{route('generateProposalForm', $link->link)}}">
        @csrf

        <h1> Proposal Form </h1>
        <div class="proposal_form_group">
            <label for="institution_name">Institution Name</label>
            <input type="text" name="institution_name" placeholder="Institution Name" required>
        </div>

        <div class="proposal_form_group">
            <label for="country">Select Country:</label>
            <select name="country" id="country">
                @foreach($countriesList as $code => $name)
                    <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="proposal_form_group">
            <label for="type_of_institution">Type of Institution</label>
            <select name="type_of_institution" id="type_of_institution" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Private Higher Educational Institution">Private Higher Educational Institution</option>
                <option value="Public Higher Educational Institution">Public Higher Educational Institution</option>
                <option value="Private Company">Private Company</option>
                <option value="Public Company">Public Company</option>
                <option value="Organization">Organization</option>
                <option value="Government Agency">Government Agency</option>
            </select>
        </div>

        <div class="proposal_form_group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="proposal_form_group">
            <label for="telephone_number">Telephone Number</label>
            <input type="text" name="telephone_number" placeholder="Telephone Number">
        </div>

        <div class="proposal_form_group">
            <label for="mobile_number">Mobile Number</label>
            <input type="text" name="mobile_number" placeholder="Mobile Number">
        </div>

        <div class="proposal_form_group">
            <label for="website">Website</label>
            <input type="text" name="website" placeholder="Website">
        </div>

        <div class="proposal_form_group">
            <label for="institution_overview">Overview of Institution</label>
            <textarea name="institution_overview" placeholder="Overview of Institution"> </textarea>
        </div>

        <!-- Accreditation Container -->
        <div class="proposal_form_group" id="accreditation_container">
            <label>Accreditations</label>
            <br>
            <small class="error-message text-danger" id="accreditation_error"></small>

            <!-- First Accreditation Form -->
            <div class="accreditation_form">
                <div class="proposal_form_group">
                    <label for="accreditation_institution_name">Institution Name</label>
                    <input type="text" name="accreditations[0][institution_name]" placeholder="Institution Name" required>
                </div>

                <div class="proposal_form_group">
                    <label for="accreditation_nature_of_partnership">Nature of Partnership</label>
                    <input type="text" name="accreditations[0][nature_of_partnership]" placeholder="Nature of Partnership" required>
                </div>

                <div class="proposal_form_group">
                    <label for="accreditation_validity_period">Validity Period</label>
                    <input type="date" name="accreditations[0][validity_period]" placeholder="Validity Period" required>
                </div>
            </div>
        </div>

        <div class="proposal_form_group">
            <label for="target_participant">Type of Institution</label>
            <select name="target_participant" id="target_participant" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Student">Student</option>
                <option value="Faculty">Faculty</option>
                <option value="Researcher">Researcher</option>
            </select>
        </div>

        <div class="proposal_form_group">
            <label for="target_level">Type of Institution</label>
            <select name="target_level" id="target_level" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Elementary">Elementary</option>
                <option value="Junior High School">Junior High School</option>
                <option value="Senior High School">Senior High School</option>
                <option value="Undergraduate">Undergraduate</option>
                <option value="Graduate School">Graduate School</option>
                <option value="Certification Program (ESL)">Certification Program (ESL)</option>
            </select>
        </div>

        <div class="proposal_form_group">
            <h3>Select Affiliate</h3>
            <select name="selected_institutionalUnit" id="institutionalUnit" class="form-control">
                <option value="">Select an Institution</option>
                @foreach($institutionalUnitList as $institutionalUnit)
                    <option value="{{ $institutionalUnit->id }}">{{ $institutionalUnit->name }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Button to Add New Accreditation Form -->
        <button type="button" id="add_accreditation_btn" class="btn btn-secondary mt-3">Add Accreditation</button>

        <!-- Category Dropdown -->
        <div>
            <div class="form-group">
                <label for="partnership_category">Select Category</label>
                <select id="partnership_category" class="form-control">
                    <option value="">-- Choose a Category --</option>
                    <option value="Non-Degree Program">Non-Degree Program</option>
                    <option value="Degree Program">Degree Program</option>
                    <option value="Mobility Program">Mobility Program</option>
                    <option value="Research Program">Research Program</option>
                </select>
            </div>
    
            <!-- Partnership Types (Radio Buttons) -->
            <div id="partnership_options" class="mt-3">
                <!-- Dynamic radio buttons will be loaded here based on the selected category -->
            </div>
        </div>

        <div class="proposal_form_group">
            <label for="partnership_overview">Overview of the Proposed Partnership</label>
            <textarea class="partnership_overview" name="partnership_overview" placeholder="Overview of the Proposed Partnership" required></textarea>
        </div>

        <div class="proposal_form_group">
            <label for="partnership_expected_outcome">Expected Outcome of the Proposed Partnership</label>
            <textarea class="partnership_expected_outcome" name="partnership_expected_outcome" placeholder="Expected Outcome of the Proposed Partnership" required></textarea>
        </div>

        <div class="proposal_form_group">
            <label for="partnership_target_participants">Target of the Proposed Partnership</label>
            <textarea class="partnership_target_participants" name="partnership_target_participants" placeholder="Target of the Proposed Partnership" required></textarea>
        </div>

        <div class="proposal_form_group">
            <h2> Prepared by: </h2>
            <label for="contact_person_name">Name</label>
            <input type="text" name="contact_person_name" placeholder="Name" required>

            <label for="contact_person_email">Email</label>
            <input type="email" name="contact_person_email" placeholder="Email" required>

            <label for="contact_person_position">Position</label>
            <input type="text" name="contact_person_position" placeholder="Position" required>

            <label for="contact_person_office">Office</label>
            <input type="text" name="contact_person_office" placeholder="Office" required>

            <label for="contact_person_telephone_number">Telephone Number</label>
            <input type="text" name="contact_person_telephone_number" placeholder="Telephone Number">

            <label for="contact_person_mobile_number">Mobile Number</label>
            <input type="text" name="contact_person_mobile_number" placeholder="Mobile Number">
        </div>

        <div>
            <h1> Memorandum </h1>
            <!-- Dropdown to Navigate between Sections -->
            <div class="form-group">
                <label for="section-navigator">Jump to Section:</label>
                <select id="section-navigator" class="form-control">
                    <option value="step-1">Step 1: Partner Information</option>
                    <option value="step-2">Step 2: Contact Information</option>
                    <option value="step-3">Step 3: Article Clauses</option>
                </select>
            </div>

            <!-- Step 1: Partner Information -->
            <div class="form-section" id="step-1">
                <h2>Step 1: Partner Information</h2>
                <div class="form-group">
                    <label for="partner_name">Partner Name</label>
                    <input type="text" class="form-control" id="partner_name" name="partner_name" value="{{ old('partner_name') }}" required>
                    <small class="error-message text-danger" id="partner_name_error"></small>
                </div>

                <!-- Edit Dropdown Options with Tag-like Input -->
                <div class="form-group">
                    <label for="custom_options">Edit Dropdown Options</label>
                    <div style="display: flex;">
                        <div id="tags-container" class="form-control" style="display: flex; min-height: 30px;" disabled>
                            <!-- Tags will appear here -->
                        </div>
                        <button type="button" class="btn btn-secondary" id="edit-options-btn">Edit</button>
                        <button type="button" class="btn btn-secondary" id="save-options-btn" style="display: none;">Save</button>
                    </div>
                    
                    <input type="text" class="form-control" id="tag-input" placeholder="Type and press comma (,) to add" style="display: none; margin-top: 5px; min-width:300px;">
                </div>

                <!-- Whereas Clauses Container -->
                <div id="whereas-clauses-container">
                    <label>Whereas Clauses</label>
                    <br>
                    <small class="error-message text-danger" id="whereas_clause_error"></small>
                    <!-- First Whereas Clause -->
                    <div class="form-group whereas-clause-item">
                        <label>Whereas,</label>
                        
                        <!-- Dropdown for Whereas Clauses -->
                        <select class="whereas-clause-select form-control" name="whereas_clauses[]">
                            <option value="the AUF">the AUF</option>
                            <option value="AUF">AUF</option>
                        </select>

                        <!-- Textarea for the Whereas Clause -->
                        <textarea class="form-control mt-2" name="whereas_clause_texts[]" placeholder="Enter full Whereas Clause" required></textarea>
                    </div>
                </div>
                
                <!-- Add New Clause Button -->
                <button type="button" class="btn btn-secondary" id="add-whereas-clause-btn">Add Another Whereas Clause</button>

                <button type="button" class="btn btn-primary" id="next-step-1">Next</button>
            </div>

            <!-- Step 2: Contact Information -->
            <div class="form-section hidden" id="step-2">
                <h2>Step 2: Contact Information</h2>
                <div class="form-group">
                    <label for="memorandum_contact_person">Contact Person</label>
                    <input type="text" class="form-control" id="memorandum_contact_person" name="memorandum_contact_person" value="{{ old('memorandum_contact_person') }}" required>
                    <small class="error-message text-danger" id="memorandum_contact_person_error"></small>
                </div>

                <div class="form-group">
                    <label for="contact_email">Contact Email</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                    <small class="error-message text-danger" id="contact_email_error"></small>
                </div>

                <button type="button" class="btn btn-secondary" id="previous-step-2">Previous</button>
                <button type="button" class="btn btn-primary" id="next-step-2">Next</button>
            </div>

            <!-- Step 3: Article Clauses -->
            <div class="form-section hidden" id="step-3">
                <h2>Step 3: Article Clauses</h2>

                <div id="article-3" class="form-group">
                    <label>Article 3 Clauses</label>
                    <textarea class="form-control" name="articles[]" required>{{ old('articles.0') }}</textarea>
                    <small class="error-message text-danger" id="article_clause_error"></small>
                </div>

                <button type="button" class="btn btn-secondary" id="previous-step-3">Previous</button>
                <button type="submit" class="btn btn-success" onclick="prepareSubmission()">Submit</button>
            </div>
        </div>
    </form>

    <!--- Script for Type of Partnership --->
    <script>
        // Partnership options grouped by category
        const partnershipOptions = {
            'Non-Degree Program': [
                { value: 'English as Second Language (ESL)', label: 'English as Second Language (ESL)' },
                { value: 'Audit Class / Sit-in Class', label: 'Audit Class / Sit-in Class' },
                { value: 'Study and Tour Program', label: 'Study and Tour Program' },
                { value: 'Conference / Seminar', label: 'Conference / Seminar' },
                { value: 'Others', label: 'Others', input: true }
            ],
            'Degree Program': [
                { value: 'Academic Franchising', label: 'Academic Franchising' },
                { value: 'Program Articulation', label: 'Program Articulation' },
                { value: 'Branch or International Campus', label: 'Branch or International Campus' },
                { value: 'Double Degree', label: 'Double Degree' },
                { value: 'Dual Degree', label: 'Dual Degree' },
                { value: 'Joint Degree', label: 'Joint Degree' },
                { value: 'Online, Blended, and Distance Learning', label: 'Online, Blended, and Distance Learning' },
                { value: 'Others', label: 'Others', input: true }
            ],
            'Mobility Program': [
                { value: 'Inbound Student', label: 'Inbound Student' },
                { value: 'Outbound Student', label: 'Outbound Student' },
                { value: 'Others', label: 'Others', input: true }
            ],
            'Research Program': [
                { value: 'Collaborative Research', label: 'Collaborative Research' },
                { value: 'Capacity Building Program', label: 'Capacity Building Program' },
                { value: 'Research Dissemination Program', label: 'Research Dissemination Program' },
                { value: 'Others', label: 'Others', input: true }
            ]
        };

        const categorySelect = document.getElementById('partnership_category');
        const partnershipOptionsContainer = document.getElementById('partnership_options');

        // Load relevant options based on category selection
        categorySelect.addEventListener('change', function() {
            const selectedCategory = categorySelect.value;
            partnershipOptionsContainer.innerHTML = ''; // Clear previous options

            if (selectedCategory && partnershipOptions[selectedCategory]) {
                // Generate radio buttons based on the selected category
                partnershipOptions[selectedCategory].forEach(option => {
                    const radioDiv = document.createElement('div');
                    radioDiv.classList.add('form-check');

                    const radioInput = document.createElement('input');
                    radioInput.type = 'radio';
                    radioInput.classList.add('form-check-input');
                    radioInput.name = 'type_of_partnership';
                    radioInput.value = option.input ? '' : `${selectedCategory} - ${option.value}`; // Set prefixed value if not "Others"
                    radioInput.id = `option_${option.value}`;
                    radioInput.required = true;

                    const label = document.createElement('label');
                    label.classList.add('form-check-label');
                    label.htmlFor = radioInput.id;
                    label.textContent = option.label;

                    // Append radio input and label to the div
                    radioDiv.appendChild(radioInput);
                    radioDiv.appendChild(label);

                    // If "Others" option, add an additional input field
                    if (option.input) {
                        const othersInput = document.createElement('input');
                        othersInput.type = 'text';
                        othersInput.classList.add('form-control', 'mt-2');
                        othersInput.name = 'type_of_partnership_other';
                        othersInput.placeholder = 'Please specify';
                        othersInput.required = false; // Make required only if "Others" selected
                        radioDiv.appendChild(othersInput);

                        // Event listener to toggle required status and update value with user input
                        radioInput.addEventListener('change', () => {
                            othersInput.required = radioInput.checked;
                            othersInput.addEventListener('input', () => {
                                radioInput.value = `${selectedCategory} - ${othersInput.value}`;
                            });
                        });
                    }

                    partnershipOptionsContainer.appendChild(radioDiv);
                });
            }
        });

        // Prepare data before submission
        function prepareSubmission() {
            const othersInput = document.querySelector('input[name="type_of_partnership_other"]');
            const selectedRadio = document.querySelector('input[name="type_of_partnership"]:checked');

            if (selectedRadio && selectedRadio.nextSibling && selectedRadio.value === '') {
                // Use the "Others" input value if filled
                selectedRadio.value = `${categorySelect.value} - ${othersInput.value}`;
            }
        }
    </script>

    <script>
        //Add Whereas Clause
        document.addEventListener('DOMContentLoaded', function () {
            const partnerNameInput = document.getElementById('partner_name');
            const tagInput = document.getElementById('tag-input');
            const tagsContainer = document.getElementById('tags-container');
            const editOptionsBtn = document.getElementById('edit-options-btn');
            const saveOptionsBtn = document.getElementById('save-options-btn');
            let isEditing = false;
            let debounceTimeout;
            let previousPartnerName = '';
            let tags = ['the AUF', 'AUF']; // Default tags

            // Render initial tags (non-editable)
            renderTags();

            // Function to update the tags based on partner name input
            function updatePartnerNameTags(partnerName) {
                // Remove previous partner name-related tags
                tags = tags.filter(tag => tag !== previousPartnerName && tag !== `the AUF and ${previousPartnerName}`);

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
            editOptionsBtn.addEventListener('click', function () {
                if (!isEditing) {
                    // Enable editing
                    tagInput.style.display = 'block'; // Show input box
                    editOptionsBtn.style.display = 'none'; // Hide "Edit" button
                    saveOptionsBtn.style.display = 'block'; // Show "Save" button
                    isEditing = true;
                    renderTags(true); // Make tags removable
                }
            });

            saveOptionsBtn.addEventListener('click', function () {
                // Save changes, disable editing
                tagInput.style.display = 'none'; // Hide input box
                saveOptionsBtn.style.display = 'none'; // Hide "Save" button
                editOptionsBtn.style.display = 'block'; // Show "Edit" button
                isEditing = false;
                renderTags(); // Make tags non-removable
            });

            // Listen for input in the tag input box
            tagInput.addEventListener('keypress', function (e) {
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
                    tagElement.style = 'background-color: #e0e0e0; border-radius: 4px; padding: 5px 10px; margin-right: 5px; display: flex; align-items: center;';

                    // Tag text
                    const tagText = document.createElement('span');
                    tagText.innerText = tag;
                    tagElement.appendChild(tagText);

                    // Remove button (x) if in editing mode
                    if (removable) {
                        const removeBtn = document.createElement('button');
                        removeBtn.innerText = 'x';
                        removeBtn.style = 'border: none; background: transparent; color: red; margin-left: 10px; cursor: pointer;';
                        removeBtn.addEventListener('click', function () {
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
            saveOptionsBtn.addEventListener('click', function () {
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

            let accreditationCount = 1; // To track number of accreditation forms

            document.getElementById('add_accreditation_btn').addEventListener('click', function() {
                // Create new accreditation form container
                const newAccreditationDiv = document.createElement('div');
                newAccreditationDiv.classList.add('accreditation_form', 'mt-3');

                // Institution Name field
                const institutionDiv = document.createElement('div');
                institutionDiv.classList.add('proposal_form_group');
                const institutionLabel = document.createElement('label');
                institutionLabel.innerText = 'Institution Name';
                const institutionInput = document.createElement('input');
                institutionInput.type = 'text';
                institutionInput.name = `accreditations[${accreditationCount}][institution_name]`;
                institutionInput.placeholder = 'Institution Name';
                institutionInput.required = true;
                institutionDiv.appendChild(institutionLabel);
                institutionDiv.appendChild(institutionInput);

                // Nature of Partnership field
                const partnershipDiv = document.createElement('div');
                partnershipDiv.classList.add('proposal_form_group');
                const partnershipLabel = document.createElement('label');
                partnershipLabel.innerText = 'Nature of Partnership';
                const partnershipInput = document.createElement('input');
                partnershipInput.type = 'text';
                partnershipInput.name = `accreditations[${accreditationCount}][nature_of_partnership]`;
                partnershipInput.placeholder = 'Nature of Partnership';
                partnershipInput.required = true;
                partnershipDiv.appendChild(partnershipLabel);
                partnershipDiv.appendChild(partnershipInput);

                // Validity Period field
                const validityDiv = document.createElement('div');
                validityDiv.classList.add('proposal_form_group');
                const validityLabel = document.createElement('label');
                validityLabel.innerText = 'Validity Period';
                const validityInput = document.createElement('input');
                validityInput.type = 'date';
                validityInput.name = `accreditations[${accreditationCount}][validity_period]`;
                validityInput.required = true;
                validityDiv.appendChild(validityLabel);
                validityDiv.appendChild(validityInput);

                // Remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.classList.add('btn', 'btn-danger', 'mt-2');
                removeBtn.innerText = 'Remove';
                removeBtn.addEventListener('click', function() {
                    newAccreditationDiv.remove();
                });

                // Append elements to the new accreditation form container
                newAccreditationDiv.appendChild(institutionDiv);
                newAccreditationDiv.appendChild(partnershipDiv);
                newAccreditationDiv.appendChild(validityDiv);
                newAccreditationDiv.appendChild(removeBtn);

                // Append the new accreditation form container to the main container
                document.getElementById('accreditation_container').appendChild(newAccreditationDiv);

                // Increment accreditation count
                accreditationCount++;
            });

            // Add another Whereas clause dynamically
            const addWhereasBtn = document.getElementById('add-whereas-clause-btn');
            addWhereasBtn.addEventListener('click', function () {
                const newClauseDiv = document.createElement('div');
                newClauseDiv.classList.add('form-group', 'whereas-clause-item');

                // Add label for Whereas
                const newLabel = document.createElement('label');
                newLabel.innerText = 'Whereas,';
                newClauseDiv.appendChild(newLabel);

                const newSelect = document.createElement('select');
                newSelect.classList.add('form-control', 'whereas-clause-select');
                newSelect.setAttribute('name', 'whereas_clauses[]');

                // Populate the new dropdown with options from the tags
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
                removeBtn.addEventListener('click', function () {
                    newClauseDiv.remove();
                });

                // Append the new select, textarea, and remove button to the new clause div
                newClauseDiv.appendChild(newSelect);
                newClauseDiv.appendChild(newTextarea);
                newClauseDiv.appendChild(removeBtn);

                // Append the new clause div to the container
                document.getElementById('whereas-clauses-container').appendChild(newClauseDiv);
            });
        });

        // Function to validate based on the current step
        function validateCurrentStep(currentStep) {
            switch (currentStep) {
                case 'step-1':
                    return validateStep1();
                case 'step-2':
                    return validateStep2();
                default:
                    return true; // No validation needed for other steps
            }
        }

        // Handle dropdown selection and validate before navigating
        document.getElementById('section-navigator').addEventListener('change', function() {
            var currentStep = document.querySelector('.form-section:not(.hidden)').id;
            var selectedSection = this.value;

            // Validate the current step before switching
            if (validateCurrentStep(currentStep)) {
                // Hide all sections
                document.querySelectorAll('.form-section').forEach(function(section) {
                    section.classList.add('hidden');
                });

                // Show the selected section
                document.getElementById(selectedSection).classList.remove('hidden');
            } else {
                // Reset dropdown back to the current step if validation fails
                document.getElementById('section-navigator').value = currentStep;
            }
        });

        // Validate Step 1: Partner Name and Whereas Clauses
        function validateStep1() {
            let isValid = true;

            // Get partner name and first whereas clause (assuming it's the first one in the form)
            const partnerName = document.getElementById('partner_name') ? document.getElementById('partner_name').value : '';
            const whereasClauseElements = document.querySelectorAll('[name="whereas_clauses[]"]');

            // Clear error messages (check if the error elements exist)
            const partnerNameError = document.getElementById('partner_name_error');
            if (partnerNameError) partnerNameError.innerText = '';

            const whereasClauseError = document.getElementById('whereas_clause_error');
            if (whereasClauseError) whereasClauseError.innerText = '';

            // Validate Partner Name
            if (partnerName.trim() === '') {
                if (partnerNameError) partnerNameError.innerText = 'Partner name is required.';
                isValid = false;
            }

            // Validate each Whereas Clause
            whereasClauseElements.forEach((clause, index) => {
                if (clause.value.trim() === '') {
                    if (whereasClauseError) whereasClauseError.innerText = `Whereas clause #${index + 1} is required.`;
                    isValid = false;
                }
            });

            return isValid;
        }

        // Validate Step 2: Contact Person and Contact Email
        function validateStep2() {
            let isValid = true;

            const contactPerson = document.getElementById('memorandum_contact_person').value;
            const contactEmail = document.getElementById('contact_email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Clear error messages
            document.getElementById('memorandum_contact_person_error').innerText = '';
            document.getElementById('contact_email_error').innerText = '';

            // Validate Contact Person
            if (contactPerson.trim() === '') {
                document.getElementById('memorandum_contact_person_error').innerText = 'Contact person is required.';
                isValid = false;
            }

            // Validate Email
            if (!emailRegex.test(contactEmail)) {
                document.getElementById('contact_email_error').innerText = 'A valid email address is required.';
                isValid = false;
            }

            return isValid;
        }

        // Handle next button for Step 1
        document.getElementById('next-step-1').addEventListener('click', function() {
            if (validateStep1()) {
                document.getElementById('step-1').classList.add('hidden');
                document.getElementById('step-2').classList.remove('hidden');
                document.getElementById('section-navigator').value = 'step-2'; // Sync dropdown
            }
        });

        // Handle next button for Step 2
        document.getElementById('next-step-2').addEventListener('click', function() {
            if (validateStep2()) {
                document.getElementById('step-2').classList.add('hidden');
                document.getElementById('step-3').classList.remove('hidden');
                document.getElementById('section-navigator').value = 'step-3'; // Sync dropdown
            }
        });

        // Handle previous buttons
        document.getElementById('previous-step-2').addEventListener('click', function() {
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
            document.getElementById('section-navigator').value = 'step-1'; // Sync dropdown
        });

        document.getElementById('previous-step-3').addEventListener('click', function() {
            document.getElementById('step-3').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            document.getElementById('section-navigator').value = 'step-2'; // Sync dropdown
        });
    </script>

@endsection
