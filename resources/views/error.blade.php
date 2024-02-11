@extends('layout')

@section('content')
<div class="bg-milk-punch-highland border-bottom border-3 border-dark">
    <div class="bg-noise">
        <div class="container vh-lg-85">
            <div class="row h-100 py-5">
                <div class="col-12 col-lg-8 order-2 order-lg-1 h-100">
                    <div class="d-flex flex-column justify-content-center text-center text-lg-start h-100">
                        <p class="fw-bold fs-1 ff-fugaz">Oops, something went wrong! 💔</p>
                        <p class="lead fs-4 ff-fredoka">Either the cat napped on the keyboard or this link has taken a quantum leap into the void. 🐈🌌</p>
                        <p class="lead fs-4 ff-fredoka">You can always find your way back <a href="{{ route('home') }}" class="text-decoration-underline text-dark fw-semibold">home</a>.</p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 order-1 order-lg-2 h-100">
                    <div class="d-flex flex-column justify-content-center h-100 mb-5">
                        <img src="{{ asset('images/groovy-heart.png') }}" alt="" class="img-fluid mx-4 mx-sm-5 mx-lg-0 px-5 px-lg-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
