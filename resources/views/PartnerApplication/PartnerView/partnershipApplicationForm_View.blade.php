@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

    <form method="POST" action="{{route('submitProspectPartnerForm', $link->link)}}">
        @csrf

        <h1>Select Institutional Unit</h1>
        @foreach($institutionalUnitList as $institutionalUnit)
            <div>
                <input 
                    type="checkbox" 
                    name="selected_institutionalUnits[]" 
                    value="{{ $institutionalUnit->id }}" 
                    id="institutionalUnit_{{ $institutionalUnit->id }}"
                >
                <label for="institutionalUnit_{{ $institutionalUnit->id }}">{{ $institutionalUnit->name }}</label>
            </div>
        @endforeach

        <h1> Proposal Form </h1>
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="institution_name" placeholder="Institution Name">

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
                <label for="contact_person">Contact Person</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required>
                <small class="error-message text-danger" id="contact_person_error"></small>
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
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>

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

            const contactPerson = document.getElementById('contact_person').value;
            const contactEmail = document.getElementById('contact_email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Clear error messages
            document.getElementById('contact_person_error').innerText = '';
            document.getElementById('contact_email_error').innerText = '';

            // Validate Contact Person
            if (contactPerson.trim() === '') {
                document.getElementById('contact_person_error').innerText = 'Contact person is required.';
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
