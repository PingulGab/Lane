@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

    <form method="POST" action="{{ url('form/' . $link->link) }}">
        @csrf
        <input type="text" name="partner_name" placeholder="Partner Name">
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="institution_name" placeholder="Institution Name">
        <textarea name="description_1" required></textarea>
        <textarea name="description_2" required></textarea>
        <button type="submit">Submit</button>
    </form>

@endsection
