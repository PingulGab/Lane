@extends('layouts.layout')

@section('title', 'LANE - Dashboard')

@section('content')

<style>
    /* Define page header style */
    @page {
        margin: 100px 25px; /* Top margin for header space */
    }

    /* Position header at the top of each page */
    .header {
        position: fixed;
        top: -60px; /* Adjust based on header height */
        left: 0;
        right: 0;
        height: 50px;
        text-align: center;
        font-size: 14px;
        border-bottom: 1px solid #000; /* Optional: underline the header */
        padding-bottom: 5px;
    }

    /* Content styling */
    .content {
        margin-top: 20px;
        text-align: center;
    }
    
    h1, h2{
        font-size: 18px;
        
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
    }

    .leading-paragraph {
        text-align: justify;
        margin-bottom: 15px;
    }

    .indented-paragraph {
        text-indent: 35px;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .indented-paragraph-list {
        padding-left: 50px;
        margin-bottom: 0px;
        line-height: 1;
    }

    .numbered-paragraph {
        text-align: justify;
        margin-bottom: 15px;
        line-height: 1.5;
        text-indent: -30px;  /* Indent the number out of the paragraph */
        padding-left: 30px;  /* Offset the paragraph text to align after the number */
    }

    .numbered-paragraphChild {
        text-align: justify;
        margin-bottom: 15px;
        line-height: 1.5;
        text-indent: 0px;  /* Indent the number out of the paragraph */
        padding-left: 35px;  /* Offset the paragraph text to align after the number */
    }

    .text-center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .italic {
        font-style: italic;
    }

    .page-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh; /* Full viewport height */
    text-align: center;
    }

    .previewStyle {
        font-family: 'Times New Roman', serif;
        font-size: 18px;
        width: 70vh;
        height: 80vh;
        overflow: auto;
        text-align: justify;
        background-color: white;
        padding: 30px;
        border-radius: 15px;
    }
</style>

<div class="memorandum-form-container">
    <div class="previewStyle">
        @include('components.endorsement_form._endorsement_form_preview', ['link' => $link])
    </div>
</div>
@endsection
