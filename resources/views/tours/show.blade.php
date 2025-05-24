@extends('layouts.app')

@section('title', $tour->title)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Tour Details</h5>
        </div>

        @php $images = $tour->images; @endphp

        <div class="d-flex flex-wrap gap-3 px-3 py-3">
            @if($images->isNotEmpty())
                @php
                    $isSingle = $images->count() === 1;
                    $style = $isSingle
                        ? 'object-fit: contain; width: 100%; max-height: 300px;'
                        : 'object-fit: cover; width: 23%; max-height: 300px;';
                @endphp

                @foreach($images->take(4) as $image)
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $tour->title }}"
                        class="rounded"
                        style="{{ $style }}">
                @endforeach
            @else
                <img
                    src="{{ asset('storage/images/no-image.png') }}"
                    alt="No image available"
                    class="rounded"
                    style="object-fit: cover; width: 30%; max-height: 200px;">
            @endif
        </div>

        <div class="card-body">
            <h2>{{ $tour->title }}</h2>

            <p class="text-muted mb-1">
                <i class="bi bi-person-circle"></i>
                Created By: {{ $tour->creator->name }}
            </p>

            <p class="text-muted">
                <i class="bi bi-calendar-event"></i>
                {{ \Carbon\Carbon::parse($tour->start_date)->format('M d, Y') }} –
                {{ \Carbon\Carbon::parse($tour->end_date)->format('M d, Y') }}
            </p>

            <div class="mt-3">
                <h5>Description</h5>
                <p>{{ $tour->description }}</p>
            </div>

            @if(in_array(auth()->user()->role, ['admin', 'tour_planner']))
                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="{{ route('tours.edit', $tour) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <form
                        action="{{ route('tours.destroy', $tour) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this tour?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>

                    <a href="{{ route('tours.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
