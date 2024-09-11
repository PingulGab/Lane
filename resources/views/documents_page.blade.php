@extends('layouts.layout')

@section('title', 'LANE - Parnterships')

@section('content')

<div class="documents-global-container">
    
    <div class="documents-header">
        <!-- Status Cards Section -->
        <div class="documents-status-cards">
            <div class="documents-status-card">
                <h2>36</h2>
                <p>Approved</p>
            </div>
            <div class="documents-status-card">
                <h2>2</h2>
                <p>Pending</p>
            </div>
            <div class="documents-status-card">
                <h2>1</h2>
                <p>Revision</p>
            </div>
            <div class="documents-status-card">
                <h2>0</h2>
                <p>Rejected</p>
            </div>
            <div class="documents-status-card">
                <h2>0</h2>
                <p>All time</p>
            </div>

            <!-- Action Buttons -->
            <div class="documents-action-buttons">
                <button class="documents-generate-btn">Generate</button>
                <button class="documents-templates-btn">Templates</button>
            </div>
        </div>
    </div>

        <div class="documents-table-container">
            <!-- Search Bar -->
            <div class="documents-search-table">
                <div class="documents-search-bar">
                    <input type="text" placeholder="Search...">
                    <button class="documents-filters-icon-btn">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <table class="documents-table">
                <thead>
                    <tr>
                        <th>File name</th>
                        <th>Partner name</th>
                        <th>Date uploaded</th>
                        <th>Affiliation</th>
                        <th>Status</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>MOA_Msn.docx</td>
                        <td>Microsoft</td>
                        <td>May 11, 2024</td>
                        <td>CCS</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>MOA_Oracle.docx</td>
                        <td>Oracle</td>
                        <td>May 10, 2024</td>
                        <td>CCS</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>CCNA_Terms.docx</td>
                        <td>CCNA</td>
                        <td>April 25, 2024</td>
                        <td>CCS</td>
                        <td><span class="status-revision">Revision</span></td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>JBL_MOA.docx</td>
                        <td>JBL Hospital San Fernando</td>
                        <td>March 30, 2024</td>
                        <td>CON</td>
                        <td><span class="status-approved">Approved</span></td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>AcSciPartnership.docx</td>
                        <td>AcSci Highschool</td>
                        <td>March 21, 2024</td>
                        <td>CED</td>
                        <td><span class="status-approved">Approved</span></td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
</div>

@endsection
