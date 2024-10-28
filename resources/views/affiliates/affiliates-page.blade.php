@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')
<div class="affiliates-container">

    <!-- Affiliates Header -->
    <h1 class="affiliates-header">Affiliates Lists</h1>

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
                <a class="affiliates-add-btn" href="{{route('showCreatePage')}}">Add</a>
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
