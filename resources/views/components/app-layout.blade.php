@props(['header' => null])

@extends('layouts.app')

@section('header', $header)

@section('content')
    {{ $slot }}
@endsection
