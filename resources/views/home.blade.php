@extends('layouts.default')

@push('css')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.js"></script> --}}
@endpush

@section('content')
    <x-widget.income-chart-widget></x-widget.income-chart-widget>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
        <x-widget.best-selling-product-widget></x-widget.best-selling-product-widget>
    </div>
@endsection
