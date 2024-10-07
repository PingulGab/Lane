@php
    $isMinimized = false;
    if (isset($_COOKIE['sidebarMinimized']) && $_COOKIE['sidebarMinimized'] === 'true') {
        $isMinimized = true;
    }
@endphp

<div class="sidebar {{ $isMinimized ? 'minimized' : '' }}">
    <div class="sidebar-header">
        <img src="{{ Vite::asset('resources/images/lane_logo_iconWhite.png') }}" alt="Minimized Logo" class="logo minimized-logo" style="{{ $isMinimized ? 'display: block;' : 'display: none;' }}">
        <img src="{{ Vite::asset('resources/images/lane_textlogo_white.png') }}" alt="Maximized Logo" class="logo maximized-logo" style="{{ $isMinimized ? 'display: none;' : 'display: block;' }}">
    </div>
    <ul class="sidebar-menu">
        <li class="{{ request()->is('dashboard') ? 'active' : '' }} ajax-link">
            <a href="{{ url('dashboard') }}">
                <span class="icon-wrapper">
                    <i class="fas fa-home"></i> <!-- Replace with your icon -->
                </span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>

        <li class="{{ request()->is('documents') ? 'active' : '' }} ajax-link">
            <a href="{{ url('documents') }}">
                <i class="fas fa-file"></i> <!-- Documents Icon -->
                <span class="menu-text">Documents</span>
            </a>
        </li>

        <li class="{{ request()->is('') ? 'active' : '' }} ajax-link">
            <a href="{{ url('') }}">
                <i class="fas fa-file-circle-plus"></i> <!-- Documents Icon -->
                <span class="menu-text">Generate</span>
            </a>
        </li>

        <li class="{{ request()->is('partnerships') ? 'active' : '' }} ajax-link">
            <a href="{{ url('partnerships') }}">
                <i class="fas fa-handshake-simple"></i> <!-- Documents Icon -->
                <span class="menu-text">Partnerships</span>
            </a>
        </li>

        <li class="{{ request()->is('statistics') ? 'active' : '' }} ajax-link">
            <a href="{{ url('statistics') }}">
                <i class="fas fa-chart-pie"></i> <!-- Documents Icon -->
                <span class="menu-text">Statistics</span>
            </a>
        </li>

        <li class="{{ request()->is('affiliates') ? 'active' : '' }} ajax-link">
            <a href="{{ url('affiliates') }}">
                <i class="fas fa-building-user"></i> <!-- Documents Icon -->
                <span class="menu-text">Affiliates</span>
            </a>
        </li>

        <li class="{{ request()->is('settings') ? 'active' : '' }} ajax-link">
            <a href="{{ url('settings') }}">
                <i class="fas fa-gear"></i> <!-- Documents Icon -->
                <span class="menu-text">Settings</span>
            </a>
        </li>

        <li class="{{ request()->is('') ? 'active' : '' }} ajax-link">
            <a href="{{ url('') }}">
                <i class="fas fa-right-from-bracket"></i> <!-- Documents Icon -->
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
