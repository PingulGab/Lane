@extends('layouts.layout')

@section('title', 'LANE - Parnterships')

@section('content')

<div class="statistics-global-container">

    <!-- Status Cards -->
    <div class="statistics-status-cards">
        <div class="statistics-status-card">
            <h2>24</h2>
            <p>Active Partnerships</p>
        </div>
        <div class="statistics-status-card">
            <h2>142</h2>
            <p>Inactive Partnerships</p>
        </div>
        <div class="statistics-status-card">
            <h2>9</h2>
            <p>International Partners</p>
        </div>
        <div class="statistics-status-card">
            <h2>14</h2>
            <p>Local Partners</p>
        </div>
    </div>

    <!-- Partnerships Section -->
    <div class="statistics-partnerships-section">
        <div class="statistics-partnerships-info">
            <div class="statistics-partnerships-info-header">
                <div class="statistics-partnership-info-header-area1">
                    <h1>Partnerships</h1>
                    <button class="statistics-filters-btn">Filters</button>
                </div>
                <div class="statistics-partnership-info-header-area2">
                    <p>Filters: By department, March 2024, Active</p>
                </div>
            </div>
            <div class="statistics-chart">
                <div class="statistics-chart-circle">
                    <p> Chart Goes Here (300 x 300)</p>
                </div>
                <div class="statistics-chart-legend">
                    <p><span class="statistics-legend-red"></span> College of Computer Studies</p>
                    <p><span class="statistics-legend-green"></span> College of Nursing</p>
                </div>
            </div>
        </div>

        <div class="statistics-partnerships-details">
            <h1>College of Nursing</h1>
            <table class="statistics-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Partnership</th>
                        <th>Established</th>
                        <th> </th>
                    </tr>
                </thead>
            </table>
            <div class="statistics-table-content">
                <table class="statistics-table">
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>JBL San Fernando</td>
                            <td>Mar. 10, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sanggunian ng Kabataan</td>
                            <td>Mar. 21, 2024</td>
                            <td><button class="statistics-view-btn">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Departments Section -->
    <div class="statistics-departments-section">
        <h2>Departments</h2>
        <input type="text" class="statistics-search-bar" placeholder="Search">
        <div class="statistics-department-list">
            <div class="statistics-department">
                <img src="path-to-logo.png" alt="Logo">
                <div class="statistics-department-details">
                    <h1> Department Name </h1>
                    <div class="statistics-department-details-numbers">
                        <p> 1st num </p>
                        <p id="statistics-separator"> | </p>
                        <p> 2nd num </p>
                    </div>
                </div>

            </div>
            <div class="statistics-department">
                <img src="path-to-logo.png" alt="Logo">
                <div class="statistics-department-details-numbers">
                    <p> 1st num </p>
                    <p id="statistics-separator"> | </p>
                    <p> 2nd num </p>
                </div>
            </div>
            <div class="statistics-department">
                <img src="path-to-logo.png" alt="Logo">
                <p>College of Nursing</p>
                <div class="statistics-department-details-numbers">
                    <p> 1st num </p>
                    <p id="statistics-separator"> | </p>
                    <p> 2nd num </p>
                </div>
            </div>
            <!-- Add more departments as needed -->
        </div>
    </div>

    <!-- Map Section -->
    <div class="statistics-map-container">
        <!-- Filter and Search Section -->
        <div class="statistics-map-filter-section">
            <div class="statistics-map-search-bar">
                <input type="text" placeholder="Search">
            </div>
            <div class="statistics-map-filter-options">
                <label for="date">Date</label>
                <select id="date" class="statistics-map-select">
                    <option value="May 2024">May 2024</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="department">Department</label>
                <select id="department" class="statistics-map-select">
                    <option value="College of Education">College of Education</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="status">Status</label>
                <select id="status" class="statistics-map-select">
                    <option value="Active">Active</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="scope">Scope</label>
                <select id="scope" class="statistics-map-select">
                    <option value="International">International</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <!-- Results Section -->
            <div class="statistics-map-results">
                <h3>Result</h3>
                <p>United States</p>
                <div class="statistics-map-progress-bar">
                    <div class="statistics-map-progress-bar-fill" style="width: 90%;"></div>
                </div>
                <p>1</p>
            </div>
        </div>

        <!-- Map Section -->
        <div class="statistics-map-section">
            <div class="statistics-map">
                <!-- The map will be embedded here (static map or dynamic map) -->
                <div class="statistics-map-pin">
                    <p><strong>Map goes here.</strong></p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
