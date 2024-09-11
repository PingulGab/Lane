@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')
<div>
    <div class="dashboard-container">
        <div class="dashboard-container-area1">
            <!-- Cards -->
            <div class="dashboard-cards-section-container">
                <!-- Cards Section -->
                <div class="dashboard-cards-section">
                    <div class="dashboard-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="dashboard-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
                    <div class="dashboard-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="dashboard-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
                </div>
        
                <div class="dashboard-cards-section">
                    <div class="dashboard-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="dashboard-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
        
                    <div class="dashboard-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="dashboard-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track Documents -->
            <div class="dashboard-track-documents">
                <div class="dashboard-track-documents-header">
                    <h1>Track Documents</h1>
                    <div class="dashboard-track-documents-search">
                        <input type="text" placeholder="Search...">
                        <button>Filters</button>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Date Uploaded</th>
                            <th>Affiliation</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Document1.pdf</td>
                            <td>2024-09-02</td>
                            <td>Department A</td>
                            <td>Approved</td>
                        </tr>
                        <tr>
                            <td>Report2.docx</td>
                            <td>2024-08-29</td>
                            <td>Department B</td>
                            <td>Pending</td>
                            <td>View</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Department Statistics -->
            <div class="dashboard-department-statistics">
                <h1>Department Statistics</h1>

                <div class="dashboard-department-statistics-content">
                    <div class="dashboard-department-statistics-heading">
                        <img src="" alt="Img">
                        <div class="dashboard-department-statistics-details">
                            <h1> Department Name </h1>
                            <div class="dashboard-department-statistics-details-numbers">
                                <p> 1st num </p>
                                <p id="dashboard-separator"> | </p>
                                <p> 2nd num </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-container-area2">
            <!-- Notifications -->
            <div class="dashboard-notifications">
                <h1>Notifications</h1>
                <div class=dashboard-notifications-content>
                    <p> 1 </p>
                    <p> Notification Sample #1 </p>
                    <p> May 1 </p>
                </div>

                <div class=dashboard-notifications-content>
                    <p> 2 </p>
                    <p> Notification Sample #2 </p>
                    <p> May 1 </p>
                </div>
            </div>

            <!-- Active Partnerships -->
            <div class="dashboard-active-partnerships">
                <div class="dashboard-active-partnerships-header">
                    <h1>Active Partnerships</h1>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Partner Name</th>
                            <th>MOA File</th>
                            <th>Validity Period</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>Partner 1</td>
                        <td>MOA_Ex</td>
                        <td>May 1, 2024</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
