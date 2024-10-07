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
                        <img src="{{ Vite::asset('resources/images/dashboard_page/dashboard_partnerships.png')}}" alt="Icon">
                        <div class="partnerships-card-content">
                            <h2>100</h2>
                            <p>Partnerships</p>
                        </div>
                    </div>
                    <div class="partnerships-card">
                        <img src="{{ Vite::asset('resources/images/dashboard_page/dashboard_pending.png')}}" alt="Icon">
                        <div class="partnerships-card-content">
                            <h2>Num</h2>
                            <p>Pending Partnerships</p>
                        </div>
                    </div>
                </div>

                <div class="partnerships-cards-section">
                    <div class="partnerships-card">
                        <img src="{{ Vite::asset('resources/images/dashboard_page/dashboard_international.png')}}" alt="Icon">
                        <div class="partnerships-card-content">
                            <h2>Num</h2>
                            <p>International Partners</p>
                        </div>
                    </div>

                    <div class="partnerships-card">
                        <img src="{{ Vite::asset('resources/images/dashboard_page/dashboard_local.png')}}" alt="Icon">
                        <div class="partnerships-card-content">
                            <h2>Num</h2>
                            <p>Local Partners</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="partnerships-container-area2">
            <!-- Near Validity Period Partnerships -->
            <div class="partnerships-validity-partnerships">
                <div class="partnerships-validity-partnerships-header">
                    <h1>Active Partnerships</h1>
                </div>
                <div class="partnerships-validity-period-container">
                    <div class="partnerships-validity-period-header">
                        <table class="partnerships-validity-table">
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
                        <table class="partnerships-validity-table">
                            <tbody>
                                <tr>
                                    <td>x</td>
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
                <h1> List of Partners </h1>
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
            </table>
            <div class="partnerships-table-content">
                <table class="partnerships-table">
                    <tbody>
                        <tr>
                            <td>Microsoft 1</td>
                            <td>
                                <div class="partnerships-table-col-affiliation">
                                    <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="Icon"/>
                                    <p> CCS </p> 
                                </div>
                            </td>
                            <td>MONTH DD, YYYY</td>
                            <td>MONTH DD, YYYY</td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>Microsoft 1</td>
                            <td>
                                <div class="partnerships-table-col-affiliation">
                                    <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="Icon"/>
                                    <p> CCS </p> 
                                </div>
                            </td>
                            <td>MONTH DD, YYYY</td>
                            <td>MONTH DD, YYYY</td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>Microsoft 1</td>
                            <td>
                                <div class="partnerships-table-col-affiliation">
                                    <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="Icon"/>
                                    <p> CCS </p> 
                                </div>
                            </td>
                            <td>MONTH DD, YYYY</td>
                            <td>MONTH DD, YYYY</td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>Microsoft 1</td>
                            <td>
                                <div class="partnerships-table-col-affiliation">
                                    <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="Icon"/>
                                    <p> CCS </p> 
                                </div>
                            </td>
                            <td>MONTH DD, YYYY</td>
                            <td>MONTH DD, YYYY</td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>Microsoft 1</td>
                            <td>
                                <div class="partnerships-table-col-affiliation">
                                    <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="Icon"/>
                                    <p> CCS </p> 
                                </div>
                            </td>
                            <td>MONTH DD, YYYY</td>
                            <td>MONTH DD, YYYY</td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>Microsoft 1</td>
                            <td>
                                <div class="partnerships-table-col-affiliation">
                                    <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="Icon"/>
                                    <p> CCS </p> 
                                </div>
                            </td>
                            <td>MONTH DD, YYYY</td>
                            <td>MONTH DD, YYYY</td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                        
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
            
        </div>
</div>

@endsection
