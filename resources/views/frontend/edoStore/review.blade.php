@extends("/frontend/layouts/template/template")

@section("content")
@php
    $store_name = DB::table('stores')->value('name');
@endphp

<div class="hero-wrap hero-bread" style="background-image: url('images/review/banner-review.png'); padding: 6em 0 !important;"></div><br>
@include("/frontend/review/$store_name")

@endsection