@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')
<div class="container">
    <h1>Create New Affiliate Account</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('affiliatesStore') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="affiliate_name">Affiliate Name</label>
            <input type="text" class="form-control" id="affiliate_name" name="affiliate_name" required>
        </div>

        <div class="form-group">
            <label for="affiliate_contact_person">Contact Person</label>
            <input type="text" class="form-control" id="affiliate_contact_person" name="affiliate_contact_person" required>
        </div>

        <div class="form-group">
            <label for="affiliate_email">Email</label>
            <input type="email" class="form-control" id="affiliate_email" name="affiliate_email" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <button type="submit" class="btn btn-success">Create Account</button>
    </form>
</div>
@endsection
