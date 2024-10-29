@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')
<div class="affiliates-container">

    <!-- Affiliates Header -->
    <h1 class="affiliates-header">Affiliates Lists</h1>

    <!-- Partners Section -->
    <div class="affiliates-partners-section">
        <div class="affiliates-partners-header">
            <h2>Partners</h2>
            <div class="affiliates-partners-controls">
                <p>Total: 12 Partners</p>
                <input type="text" placeholder="Search" class="affiliates-search-bar">
                <button class="affiliates-filters-btn">Filters</button>
                <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                <a class="affiliates-delete-btn" href="{{route('showNewAffiliateForm')}}"><i class="fas fa-plus"></i></a>
            </div>
        </div>
        <!-- Partners Table -->
        <table class="affiliates-table">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Partner name</th>
                    <th>Representative</th>
                    <th>Email Address</th>
                    <th>Address</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Angeles University Foundation</td>
                    <td>Joseph Emmanuel L. Angeles</td>
                    <td>angeles,josephemanuel@auf.edu.ph</td>
                    <td>#123, Angeles City...</td>
                    <td>
                        <a href="#" class="affiliates-edit-btn">Edit</a>
                        <a href="#" class="affiliates-view-btn">View</a>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Microsoft</td>
                    <td>Bill Gates</td>
                    <td>bill.gates@microsoft@auf.edu.ph</td>
                    <td>#123, Angeles City...</td>
                    <td>
                        <a href="#" class="affiliates-edit-btn">Edit</a>
                        <a href="#" class="affiliates-view-btn">View</a>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Amazon</td>
                    <td>Jeff Bazos</td>
                    <td>bazos,jeff@amazon.com</td>
                    <td>#123, Angeles City...</td>
                    <td>
                        <a href="#" class="affiliates-edit-btn">Edit</a>
                        <a href="#" class="affiliates-view-btn">View</a>
                    </td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Departments Section -->
    <div class="affiliates-departments-section">
        <div class="affiliates-departments-header">
            <div class="affiliates-departments-header-container">
                <h2>Affiliates</h2>
                <p>Total: 12 Departments</p>
            </div>
            <div class="affiliates-departments-controls">
                <input type="text" placeholder="Search" class="affiliates-search-bar">
                <button type="submit" class="affiliates-filters-btn" href="">Filters</button>
                <a class="affiliates-add-btn" href="{{route('showNewCollegeForm')}}">Add</a>
            </div>
        </div>

        <!-- Departments Cards -->
        <div class="affiliates-departments-cards">
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="{{ Vite::asset('resources/images/test_images/test_ccs.png')}}" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <div class="affiliates-card">
                <div class="affiliates-card-header">
                    <div class="affiliates-card-logo-container">
                        <img src="path-to-logo" alt="CAMP Logo" class="affiliates-card-logo">
                    </div>
                    <div class="affiliates-card-title-container">
                        <h3>CAMP</h3>
                        <p>College of Allied and Medical Professions</p>
                    </div>
                </div>
                <p><strong>Contact Person:</strong> Juan Miguel Karlos Dela Cruz</p>
                <p><strong>Email:</strong> delacruz.juan@auf.edu.ph</p>
                <p><strong>Department Email:</strong> camp@auf.edu.ph</p>
                <div class="affiliates-card-buttons">
                    <button class="affiliates-delete-btn"><i class="fas fa-trash"></i></button>
                    <button class="affiliates-edit-btn">Edit</button>
                    <button class="affiliates-view-btn">View</button>
                </div>
            </div>
            <!-- Add more cards as needed -->
        </div>
    </div>
</div>
@endsection
