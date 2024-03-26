@extends('layout')

@section('content')
<div class="bg-milk-punch-highland border-bottom border-3 border-dark">
    <div class="bg-noise">
        <div class="container">
            <p class="fw-bold fs-1 ff-fugaz text-center pt-5">Here's your pack of URLs! 📦</p>

            <div class="row py-5">
                <div class="col-lg-8 offset-lg-2">
                    @foreach ($original_urls as $original_url)
                        <div class="card border border-3 border-dark shadow-none mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $original_url->preview ? $original_url->preview['title'] : 'N/A' }}</h5>
                                <p class="card-text">{{ $original_url->preview ? $original_url->preview['description'] : 'N/A' }}</p>

                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img src="{{ $original_url->preview ? $original_url->preview['favicon'] : asset('images/placeholder.png') }}" alt="" class="img-fluid">
                                    </div>
                                    <small>{{ $original_url->url }}</small>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <a href="{{ $original_url->preview ? $original_url->preview['url'] : '' }}" target="_blank" class="btn btn-warning border-top border-3 border-dark text-dark rounded-0 rounded-bottom shadow-none w-100">
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
