@extends('rialchi.layouts.site')

@push('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/css/port-scene.css') }}">
@endpush

@section('content')
    @include('rialchi.sections.hero')
    @include('rialchi.sections.journey')
    @include('rialchi.sections.about')
    @include('rialchi.sections.confidence')
    @include('rialchi.sections.services')
    @include('rialchi.sections.promise')
    @include('rialchi.sections.contact')
@endsection
