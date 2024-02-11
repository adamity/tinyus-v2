@extends('layout')

@section('content')
<div class="bg-milk-punch-highland border-bottom border-3 border-dark">
    <div class="bg-noise">
        <div class="container">
            <p class="fw-bold fs-1 ff-fugaz text-center pt-5 mb-5">Here's your pack of URLs! 📦</p>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    @foreach ($original_urls as $original_url)
                        <div class="card mb-3">
                            <div class="card-body">
                                {{-- Title --}}
                                <h5 class="card-title">{{ $original_url->preview ? $original_url->preview['title'] : 'N/A' }}</h5>
                                {{-- Description --}}
                                <p class="card-text">{{ $original_url->preview ? $original_url->preview['description'] : 'N/A' }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        {{-- Favicon --}}
                                        <img src="{{ $original_url->preview ? $original_url->preview['favicon'] : asset('images/placeholder.png') }}" alt="" class="img-fluid">
                                    </div>
                                    {{-- URL --}}
                                    <small>{{ $original_url->url }}</small>
                                </div>
                            </div>
                        </div>
                        {{-- Thumbnail --}}
                        {{-- <img src="{{ $original_url->preview ? $original_url->preview['thumbnail'] : asset('images/placeholder.png') }}" alt="" class="img-fluid"> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
