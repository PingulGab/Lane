@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <div>
        <h2>Generate a Link</h2>
        <form id="generateLinkForm">
            @csrf
            <div>
                <label for="name">Link Title</label>
                <input type="text" id="name" name="name" required placeholder="Enter a title for the link">
            </div>
            <button type="button" id="generateLinkButton">Generate Link</button>
        </form>
    </div>

    <!-- The Modal -->
    <div id="linkModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Link Generated!</h2>
            <p>Your link has been successfully generated.</p>
            <p>Link: <a href="#" id="generatedLink" target="_blank">Click Here</a></p>
            <p>Password: <span id="generatedPassword"></span></p>
        </div>
    </div>

    <h2>Your Generated Links</h2>
    <ul id="generatedLinksList">
        @foreach ($links as $link)
        <li>
            <strong>{{ $link->name }}</strong>: 
            <a href="{{ route('prospectPartnerViewLink', $link->link) }}">{{ url('/link/' . $link->link) }}</a>
            <form method="POST" action="{{ route('delete-link', $link->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
        @endforeach
    </ul>
<script>
// Get the CSRF token value from the meta tag
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Get the modal
var modal = document.getElementById('linkModal');

// Get the button that opens the modal
var btn = document.getElementById('generateLinkButton');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// Get the list element where new links will be added
var linksList = document.getElementById('generatedLinksList');

// Function to handle form submission and show the modal
btn.onclick = function(event) {
    event.preventDefault(); // Prevent the form from submitting

    // Get the form data
    var formData = new FormData(document.getElementById('generateLinkForm'));

    // Make an AJAX POST request
    fetch("{{ route('storeNewLink') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.link && data.password) {
            // Update the modal with the generated link and password
            document.getElementById('generatedLink').href = data.link;
            document.getElementById('generatedLink').textContent = data.link;
            document.getElementById('generatedPassword').textContent = data.password;

            // Display the modal
            modal.style.display = "block";

            // Append the new link to the list
            var newListItem = document.createElement('li');
            newListItem.innerHTML = `
                <strong>${data.name}</strong>: 
                <a href="${data.link}" target="_blank">${data.link}</a>
                <form method="POST" action="{{ route('delete-link', '') }}/${data.id}">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
                </form>
            `;
            linksList.appendChild(newListItem); // Add new item to the list
        } else {
            alert('Error generating the link.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
}


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
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
