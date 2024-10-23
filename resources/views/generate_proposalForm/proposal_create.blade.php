@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Create Proposal Form</h1>

        <!-- Dropdown to Navigate between Sections -->
        <div class="form-group">
            <label for="section-navigator">Jump to Section:</label>
            <select id="section-navigator" class="form-control">
                <option value="step-1">Step 1: General Information</option>
                <option value="step-2">Step 2: Contact Information</option>
            </select>
        </div>

        <form id="multi-step-form" action="{{ route('generateProposal') }}" method="POST">
            @csrf

            <!-- Step 1 -->
            <div class="form-section" id="step-1">
                <h2>Step 1: General Information</h2>
                <div class="form-group">
                    <label for="institution_name">Insitution Name</label>
                    <input type="text" class="form-control" id="institution_name" name="institution_name" value="{{ old('institution_name') }}" required>
                    <small class="error-message text-danger" id="institution_name_error"></small>
                </div>
                
                <button type="button" class="btn btn-primary" id="next-step-1">Next</button>
            </div>

            <!-- Step 2 -->
            <div class="form-section hidden" id="step-2">
                <h2>Step 2: Country Information</h2>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" required>
                    <small class="error-message text-danger" id="country_error"></small>
                </div>

                <button type="button" class="btn btn-secondary" id="previous-step-2">Previous</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

    <script>
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

        // Validate Step 1: Institution Name and Whereas Clauses
        function validateStep1() {
            let isValid = true;

            // Get partner name and first whereas clause (assuming it's the first one in the form)
            const insitutionName = document.getElementById('institution_name') ? document.getElementById('institution_name').value : '';

            // Clear error messages (check if the error elements exist)
            const insitutionNameError = document.getElementById('institution_name_error');
            if (insitutionNameError) insitutionNameError.innerText = '';

            // Validate Partner Name
            if (insitutionName.trim() === '') {
                if (insitutionNameError) insitutionNameError.innerText = 'Institution name is required.';
                isValid = false;
            }

            return isValid;
        }

        // Validate Step 2: Contact Person
        function validateStep2() {
            let isValid = true;

            const country = document.getElementById('country').value;

            // Clear error messages
            document.getElementById('country_error').innerText = '';

            // Validate Contact Person
            if (country.trim() === '') {
                document.getElementById('country_error').innerText = 'Country is required.';
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

        // Handle previous buttons
        document.getElementById('previous-step-2').addEventListener('click', function() {
            if (validateStep2()) {
                document.getElementById('step-2').classList.add('hidden');
                document.getElementById('step-1').classList.remove('hidden');
                document.getElementById('section-navigator').value = 'step-1'; // Sync dropdown
            }
        });

    </script>
@endsection
