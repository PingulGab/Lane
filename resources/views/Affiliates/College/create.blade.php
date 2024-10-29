@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<form id="createNewCollege">
    @csrf

    <!-- Name Field -->
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Username Field -->
    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Email Field -->
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Contact Person Field -->
    <input type="text" name="contact_person" placeholder="Contact Person" value="{{ old('contact_person') }}" required>
    @error('contact_person')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="button" id="createCollegeBtn">Create</button>
</form>

<!-- The Modal -->
<div id="linkModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>College Created!</h2>
        <p>College Named: <strong> <span id="collegeName"></span> </strong> been created.</p>
        <p>Password: <span id="generatedPassword"></span></p>
    </div>
</div>

<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2> Error </h2>
        <p id="errorModalContent"> </p>
    </div>
</div>
<script>
    // Get the CSRF token value from the meta tag
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Get the modal
    var modal = document.getElementById('linkModal');

    var errModal = document.getElementById('errorModal');
    
    // Get the button that opens the modal
    var btn = document.getElementById('createCollegeBtn');
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName('close')[0];
    var errSpan = document.querySelectorAll('.close')[1]; // Select the second close button for the error modal
    
    // Function to handle form submission and show the modal
    btn.onclick = function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Get the form data
        var formData = new FormData(document.getElementById('createNewCollege'));

        // Make an AJAX POST request
        fetch("{{ route('storeNewCollege') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        })
        .then(response => {
            // Check if the response status is OK (200)
            if (!response.ok) {
                return response.json().then(errorData => { throw errorData });
            }
            return response.json();
        })
        .then(data => {
            // Check if the data contains the expected fields
            if (data.name && data.password) {
                // Update the modal with the generated name and password
                document.getElementById('collegeName').textContent = data.name;
                document.getElementById('generatedPassword').textContent = data.password;

                // Display the modal
                modal.style.display = "block";
            } else {
                alert('Error.');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Clear previous errors
            const errorModalContent = document.getElementById('errorModalContent');
            errorModalContent.innerHTML = ''; // Clear existing content

            // Check if there are errors
            if (error.errors) {
                // Loop through the errors and create paragraphs
                Object.values(error.errors).forEach(errArray => {
                    errArray.forEach(err => {
                        const errorParagraph = document.createElement('p'); // Create a paragraph for each error
                        errorParagraph.textContent = err; // Set the text of the paragraph
                        errorModalContent.appendChild(errorParagraph); // Append the paragraph to the modal content
                    });
                });
            } else {
                alert('An unexpected error occurred. Please try again.');
            }

            // Display the error modal
            errModal.style.display = "block"; // Assuming you have a modal for errors
        });
    }   
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks on the close button of the error modal, close it
    errSpan.onclick = function() {
        errModal.style.display = "none"; // Close the error modal
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        } else if (event.target == errModal) {
            errModal.style.display = "none";
        }
    }
</script>

<style>
    
    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      padding-top: 100px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      text-align: center;
      border-radius: 8px;
    }
    
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
      color: black;
    }
    </style>
@endsection
