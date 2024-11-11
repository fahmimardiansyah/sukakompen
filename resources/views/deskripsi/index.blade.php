@extends('layouts.template') <!-- Atur layout yang sesuai di aplikasi kamu -->

@section('content')
<div class="deskripsi-container">
    @foreach ($descriptions as $description)
        <div class="deskripsi-cont">
            <div class="deskripsi-image">
                <img src="{{ asset($description->image ?? 'images/default-image.png') }}" alt="Deskripsi Image">
            </div>
            <div class="deskripsi-content">
                <h2>{{ $description->title }}</h2>
                <div class="deskripsi-tags">
                    <span class="tag offline">{{ $description->category }}</span>
                    <!-- Tambahkan tag lain jika diperlukan -->
                </div>
                <p class="deskripsi-description">
                    {{ $description->description }}
                </p>
                <div class="deskripsi-details">
                    <div class="deskripsi-time">
                        <span><i class="fas fa-clock"></i> {{ $description->created_at->format('H:i A') }}</span>
                        <span><i class="fas fa-calendar-alt"></i> {{ $description->created_at->format('m/d/Y') }}</span>
                    </div>
                    <div class="deskripsi-duration">
                        <span><i class="fas fa-arrow-down"></i> - {{ $description->duration ?? 'N/A' }}</span>
                        <span>{{ $description->status ?? 'N/A' }}</span>
                    </div>
                </div>
                <a href="{{ route('descriptions.show', $description->id) }}" class="request-button">View Details</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
