@php
    $isMinimized = false;
    if (isset($_COOKIE['sidebarMinimized']) && $_COOKIE['sidebarMinimized'] === 'true') {
        $isMinimized = true;
    }
@endphp

@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="sidebar {{ $isMinimized ? 'minimized' : '' }}">
    <div class="sidebar-header">
        <img src="{{ Vite::asset('resources/images/lane_logo_iconWhite.png') }}" alt="Minimized Logo" class="logo minimized-logo" style="{{ $isMinimized ? 'display: block;' : 'display: none;' }}">
        <img src="{{ Vite::asset('resources/images/lane_textlogo_white.png') }}" alt="Maximized Logo" class="logo maximized-logo" style="{{ $isMinimized ? 'display: none;' : 'display: block;' }}">
    </div>
    <ul class="sidebar-menu">
        <li class="{{ request()->is('dashboard') ? 'active' : '' }} ajax-link">
            <a href="{{ url('dashboard') }}">
                <span class="icon-wrapper">
                    <i class="fas fa-home"></i>
                </span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>

        <li class="{{ request()->is('documents') ? 'active' : '' }} ajax-link">
            <a href="{{ url('documents') }}">
                <i class="fas fa-file"></i>
                <span class="menu-text">Documents</span>
            </a>
        </li>

        <!-- Generate Menu Item -->
        <li class="generate-menu" style="background-color:var(--Secondary)">
            <a href="javascript:void(0);" onclick="toggleSubMenu()">
                <i class="fas fa-file-circle-plus"></i>
                <span class="menu-text">Generate</span>
                <i class="fas fa-chevron-down submenu-icon" style="margin: 5px;"></i>
            </a>
            <!-- Submenu -->
            <ul class="submenu" style="display: none;">
                <li class="{{ request()->is('memorandum/create') ? 'active' : '' }} ajax-link">
                    <a href="{{ url('memorandum/create') }}">MOA/MOU</a>
                </li>
                <li class="{{ request()->is('proposal-form/create') ? 'active' : '' }} ajax-link">
                    <a href="{{ url('proposal-form/create') }}">Proposal Form</a>
                </li>
                <li class="{{ request()->is('endorsement-form/create') ? 'active' : '' }} ajax-link">
                    <a href="{{ url('endorsement-form/create') }}">Endorsement Form</a>
                </li>
                <li class="{{ request()->is('partnerships') ? 'active' : '' }} ajax-link">
                    <a href="{{ url('generate-other') }}">Generate Link</a>
                </li>
            </ul>
        </li>

        <li class="{{ request()->is('partnerships') ? 'active' : '' }} ajax-link">
            <a href="{{ url('partnerships') }}">
                <i class="fas fa-handshake-simple"></i>
                <span class="menu-text">Partnerships</span>
            </a>
        </li>

        <li class="{{ request()->is('statistics') ? 'active' : '' }} ajax-link">
            <a href="{{ url('statistics') }}">
                <i class="fas fa-chart-pie"></i>
                <span class="menu-text">Statistics</span>
            </a>
        </li>

        <li class="{{ request()->is('affiliates') ? 'active' : '' }} ajax-link">
            <a href="{{ url('affiliates') }}">
                <i class="fas fa-building-user"></i>
                <span class="menu-text">Affiliates</span>
            </a>
        </li>

        <li class="{{ request()->is('settings') ? 'active' : '' }} ajax-link">
            <a href="{{ url('settings') }}">
                <i class="fas fa-gear"></i>
                <span class="menu-text">Settings</span>
            </a>
        </li>

        <li class="{{ request()->is('') ? 'active' : '' }} ajax-link">
            <a href="{{ url('') }}">
                <i class="fas fa-right-from-bracket"></i>
                <span class="menu-text">Logout</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <button class="toggle-sidebar" onclick="toggleSidebar()">
            <i class="fas fa-left-long"></i> 
        </button>
    </div>
</div>

<script>
    
// resources/js/sidebar.js

document.addEventListener('DOMContentLoaded', function () {
    const menuItem = document.querySelector('.generate-menu');
    const submenu = menuItem.querySelector('.submenu');
    const submenuIcon = menuItem.querySelector('.submenu-icon');

    // Check the stored state from localStorage
    const isSubmenuExpanded = localStorage.getItem('submenu-expanded');

    // If the state is stored as 'true', expand the submenu
    if (isSubmenuExpanded === 'true') {
        submenu.style.display = 'block';
        menuItem.classList.add('active');
    }

    // Toggle submenu function
    function toggleSubMenu() {
        const isCurrentlyExpanded = submenu.style.display === 'block';

        if (isCurrentlyExpanded) {
            submenu.style.display = 'none';
            menuItem.classList.remove('active');
            localStorage.setItem('submenu-expanded', 'false'); // Store the collapsed state
        } else {
            submenu.style.display = 'block';
            menuItem.classList.add('active');
            localStorage.setItem('submenu-expanded', 'true'); // Store the expanded state
        }
    }

    // Attach the toggle function to the click event
    menuItem.querySelector('a').addEventListener('click', toggleSubMenu);
});


</script>