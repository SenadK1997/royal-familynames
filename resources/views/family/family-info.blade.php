@extends('layouts.master')
@section('title')
    RoyalFamilyNames - Family Page
@endsection

@section('content')
    {{ $family->family_code }}
@endsection