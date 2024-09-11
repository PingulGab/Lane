@extends('layouts.layout')

@section('title', 'LANE - Parnterships')

@section('content')

<div class="partnerships-global-container">
    <div class="partnerships-container">

        <div class="partnerships-container-area1">
            <!-- Cards -->
            <div class="partnerships-cards-section-container">
                <!-- Cards Section -->
                <div class="partnerships-cards-section">
                    <div class="partnerships-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="partnerships-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
                    <div class="partnerships-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="partnerships-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
                </div>

                <div class="partnerships-cards-section">
                    <div class="partnerships-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="partnerships-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>

                    <div class="partnerships-card">
                        <img src="path-to-icon.png" alt="Icon">
                        <div class="partnerships-card-content">
                            <p>Num</p>
                            <p>Partnerships</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="partnerships-container-area2">
            <!-- Active Partnerships -->
            <div class="partnerships-active-partnerships">
                <div class="partnerships-active-partnerships-header">
                    <h1>Active Partnerships</h1>
                </div>
                <div class="partnerships-validity-period-container">
                    <div class="partnerships-validity-period-header">
                        <table>
                            <thead>
                                <tr>
                                    <th>Partner Name</th>
                                    <th>MOA File</th>
                                    <th>Validity Period</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="partnerships-validity-period-table-content">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Partner 1</td>
                                    <td>MOA_Ex</td>
                                    <td>May 1, 2024</td>
                                </tr>
                                <tr>
                                    <td>Partner 1</td>
                                    <td>MOA_Ex</td>
                                    <td>May 1, 2024</td>
                                </tr>
                                <tr>
                                    <td>Partner 1</td>
                                    <td>MOA_Ex</td>
                                    <td>May 1, 2024</td>
                                </tr>
                                <tr>
                                    <td>Partner 1</td>
                                    <td>MOA_Ex</td>
                                    <td>May 1, 2024</td>
                                </tr>
                                <tr>
                                    <td>Partner 1</td>
                                    <td>MOA_Ex</td>
                                    <td>May 1, 2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>

        <div class="partnerships-table-container">
            <div class="partnerships-header">

            </div>
            
            <!-- Search Bar -->
            <div class="partnerships-search-table">
                <div class="partnerships-search-bar">
                    <input type="text" placeholder="Search...">
                    <button class="partnerships-filters-icon-btn">Filter</button>
                </div>
            </div>

            <!-- Table -->
            <table class="partnerships-table">
                <thead>
                    <tr>
                        <th>Partner name</th>
                        <th>Affiliation</th>
                        <th>Date Established</th>
                        <th>End Date</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Microsoft 1</td>
                        <td><img src="" alt="Icon"/> CCS </td>
                        <td>MONTH DD, YYYY</td>
                        <td>MONTH DD, YYYY</td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>Microsoft 2</td>
                        <td><img src="" alt="Icon"/> CCS </td>
                        <td>MONTH DD, YYYY</td>
                        <td>MONTH DD, YYYY</td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>Google</td>
                        <td><img src="" alt="Icon"/> CCS </td>
                        <td>MONTH DD, YYYY</td>
                        <td>MONTH DD, YYYY</td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>Facebook</td>
                        <td><img src="" alt="Icon"/> CCS </td>
                        <td>MONTH DD, YYYY</td>
                        <td>MONTH DD, YYYY</td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <tr>
                        <td>Instagram</td>
                        <td><img src="" alt="Icon"/> CCS </td>
                        <td>MONTH DD, YYYY</td>
                        <td>MONTH DD, YYYY</td>
                        <td><button class="documents-view-btn">View</button></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
</div>

@endsection
