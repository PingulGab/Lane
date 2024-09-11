import './bootstrap';
import.meta.glob(['../images/**']);

function setSidebarState() {
    const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';
    document.cookie = "sidebarMinimized=" + isMinimized + "; path=/";
}

// Call this function when the sidebar is toggled
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const minimizedLogo = document.querySelector('.minimized-logo');
    const maximizedLogo = document.querySelector('.maximized-logo');
    sidebar.classList.toggle('minimized');

    // Save the state to localStorage
    const isMinimized = sidebar.classList.contains('minimized');
    localStorage.setItem('sidebarMinimized', isMinimized);
    
    // Toggle the logos instantly
    if (isMinimized) {
        minimizedLogo.style.display = 'block';
        maximizedLogo.style.display = 'none';
    } else {
        minimizedLogo.style.display = 'none';
        maximizedLogo.style.display = 'block';
    }

    // Update the cookie with the new state
    setSidebarState();
}

document.addEventListener('DOMContentLoaded', () => {
    // Set the sidebar state based on localStorage
    setSidebarState();
    const sidebar = document.querySelector('.sidebar');
    const minimizedLogo = document.querySelector('.minimized-logo');
    const maximizedLogo = document.querySelector('.maximized-logo');
    const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';

    if (isMinimized) {
        sidebar.classList.add('minimized');
        minimizedLogo.style.display = 'block';
        maximizedLogo.style.display = 'none';
    } else {
        sidebar.classList.remove('minimized');
        minimizedLogo.style.display = 'none';
        maximizedLogo.style.display = 'block';
    }
});
// Make the function globally accessible
window.toggleSidebar = toggleSidebar;

$(document).ready(function() {
    $('.ajax-link').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#main-content').html($(data).find('#main-content').html());
                window.history.pushState(null, null, url);
            },
            error: function(xhr, status, error) {
                console.error('An error occurred while loading the content.');
            }
        });
    });

    // Handle browser back/forward button navigation
    window.onpopstate = function() {
        $.ajax({
            url: location.href,
            success: function(data) {
                $('#main-content').html($(data).find('#main-content').html());
            }
        });
    };
});
