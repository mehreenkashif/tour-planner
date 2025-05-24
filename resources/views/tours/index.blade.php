
@extends('layouts.app')

@section('title', 'All Tours')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-2xl font-bold">Tours</h1>
        @if(in_array(auth()->user()->role, ['admin', 'tour_planner']))
            <a href="{{ route('tours.create') }}" class="btn btn-primary">Create Tour</a>
        @endif
    </div>

    @if(session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if($tours->isEmpty())
        <p>No tours found.</p>
    @else
        <div class="row g-4">
            @foreach($tours as $tour)
                @php
                    $imagePath = $tour->images->first()->image_path ?? null;
                    $imageUrl = $imagePath
                        ? asset("storage/{$imagePath}")
                        : asset("storage/images/no-image.png");
                @endphp

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">

                        <img  src="{{ $imageUrl }}" alt="{{ $tour->title }}" class="card-img-top"style="height: 180px; object-fit: cover;"/>

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">{{ Str::limit($tour->title, 30) }}</h5>

                            <p class="card-text flex-grow-1">
                                {{ Str::limit($tour->description, 80) }}
                            </p>

                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($tour->start_date)->format('M d, Y') }} -
                                {{ \Carbon\Carbon::parse($tour->end_date)->format('M d, Y') }}
                            </small>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('tours.show', $tour) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> View Details
                                </a>

                                @if(in_array(auth()->user()->role, ['admin', 'tour_planner']))
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('tours.edit', $tour) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tour?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
