@extends('layout')

@section('content')
<div class="bg-milk-punch-highland border-bottom border-3 border-dark">
    <div class="bg-noise">
        <div class="container vh-lg-85">
            <div class="row h-100 py-5">
                <div class="col-12 col-lg-8 order-2 order-lg-1 h-100">
                    <div class="d-flex flex-column justify-content-center text-center text-lg-start h-100">
                        <p class="fw-bold fs-1 ff-fugaz">The only URL shortener you'll ever need, probably...</p>
                        <p class="lead fs-4 mb-5 ff-fredoka">Squeezing long URLs into itty-bitty ones because life's too short for long web addresses! ✨😜</p>
                        <a href="#shorten">
                            <button class="btn btn-lg btn-amber border border-3 border-dark px-5 mx-auto mx-lg-0 me-lg-auto rounded-5">Go Tiny! 🤏</button>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-lg-4 order-1 order-lg-2 h-100">
                    <div class="d-flex flex-column justify-content-center h-100 mb-5">
                        <img src="{{ asset('images/groovy-pizza.png') }}" alt="" class="img-fluid mx-4 mx-sm-5 mx-lg-0 px-5 px-lg-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="shorten" class="bg-highland bg-noise border-bottom border-3 border-dark">
    <div class="container py-5">
        <div class="card bg-perfume border border-3 border-dark shadow-none vh-lg-80">
            <div class="card-body h-100">
                <div class="row h-100">
                    <div class="col-12 col-lg-8 h-100 px-0 px-lg-2">
                        <div class="card bg-transparent shadow-none rounded-0 h-100">
                            <div class="card-header px-0 px-md-3 border-0">
                                <p class="fw-bold fs-3 ff-fugaz m-0">Shorten URLs 🔮</p>
                            </div>

                            <div class="card-body scroller p-2 p-md-3 p-lg-auto vh-80 vh-lg-auto">
                                <form>
                                    <div class="d-flex mb-3">
                                        <input type="text" class="form-control form-control-lg border border-3 border-dark rounded-5" placeholder="https://example.com/this-url-is-too-long" aria-label="https://example.com/this-url-is-too-long">
                                        <button class="btn btn-warning border border-3 border-dark rounded-5 shadow-none ms-1 ms-md-3 px-3" type="button" onclick="addInput()" id="button-add">➕</button>
                                    </div>
                                    <div id="addon-container"></div>
                                </form>

                                <button class="btn btn-lg btn-amber border border-3 border-dark w-100 rounded-5">Go Tiny! 🤏</button>
                            </div>

                            <div class="card-footer px-0 px-md-3 border-0">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                    <p class="fw-bold fs-5 ff-fugaz m-0 me-3">⚙️ Options:</p>

                                    <div class="d-flex d-none d-md-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center flex-fill">
                                        <div class="d-flex">
                                            <button class="btn btn-warning border border-3 border-dark rounded-5 shadow-none px-3" type="button" onclick="updateMaxClick(-1)" id="button-inclick">➖</button>
                                            <input type="text" class="form-control form-control-lg border border-3 border-dark rounded-5 mx-1" style="width: 100px" placeholder="Max Click" aria-label="Max Click" value="" id="max-click" disabled>
                                            <button class="btn btn-warning border border-3 border-dark rounded-5 shadow-none px-3" type="button" onclick="updateMaxClick(1)" id="button-declick">➕</button>
                                        </div>

                                        <input type="date" class="form-control form-control-lg border border-3 border-dark rounded-5 mx-1" style="width: 200px" placeholder="Expiry Date" aria-label="Expiry Date" value="" id="expiry-date" min="{{ date('Y-m-d') }}">
                                        <button class="btn btn-lg btn-danger border border-3 border-dark rounded-5 shadow-none px-3" type="button" onclick="document.getElementById('expiry-date').value = ''; document.getElementById('max-click').value = ''" id="button-clear">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4 h-100 px-0 px-lg-2">
                        <div class="card bg-link-water border border-3 border-dark shadow-none h-100">
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-12 p-0">
                                        <img src="{{ asset('images/qr-placeholder.png') }}" alt="" class="img-fluid border border-dark">
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-12 p-0">
                                        <div class="row">
                                            <div class="col-12 mt-3 mt-md-0 mt-lg-3">
                                                <button type="button" class="btn btn-outline-dark border border-3 border-dark rounded-pill px-4" disabled>📋 Shorten Link Here...</button>
                                            </div>

                                            <div class="col-12 col-lg-6 mt-3">
                                                <button class="btn btn-amber border border-3 border-dark rounded-5 w-100" disabled>QR Code 📥</button>
                                            </div>

                                            <div class="col-12 col-lg-6 mt-3">
                                                <button class="btn btn-amber border border-3 border-dark rounded-5 w-100" disabled>Analytics 📊</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addInput() {
        const container = document.getElementById('addon-container');

        const div = document.createElement('div');
        const input = document.createElement('input');
        const button = document.createElement('button');

        div.className = 'd-flex mb-3';

        input.type = 'text';
        input.className = 'form-control form-control-lg border border-3 border-dark rounded-5';
        input.placeholder = 'https://example.com/this-url-is-too-long';
        input.setAttribute('aria-label', 'https://example.com/this-url-is-too-long');

        button.className = 'btn btn-danger border border-3 border-dark rounded-5 shadow-none ms-1 ms-md-3 px-3';
        button.type = 'button';
        button.setAttribute('onclick', 'deleteInput(this)');
        button.id = 'button-delete';
        button.innerHTML = '🗑️';

        div.appendChild(input);
        div.appendChild(button);

        container.appendChild(div);
    }

    function deleteInput(element) {
        element.parentNode.remove();
    }

    function updateMaxClick(value) {
        const maxClick = document.getElementById('max-click');
        const currentMaxClick = maxClick.value == '' ? 0 : parseInt(maxClick.value);
        const newMaxClick = currentMaxClick + value;

        maxClick.value = newMaxClick <= 0 ? '' : newMaxClick;
    }

    let inclickTimeout;
    let declickTimeout;

    document.getElementById('button-inclick').addEventListener('mousedown', function() {
        inclickTimeout = setTimeout(function() {
            inclickTimeout = setInterval(function() {
                updateMaxClick(-1);
            }, 100);
        }, 500);
    });

    document.getElementById('button-inclick').addEventListener('mouseup', function() {
        clearTimeout(inclickTimeout);
        clearInterval(inclickTimeout);
    });

    document.getElementById('button-declick').addEventListener('mousedown', function() {
        declickTimeout = setTimeout(function() {
            declickTimeout = setInterval(function() {
                updateMaxClick(1);
            }, 100);
        }, 500);
    });

    document.getElementById('button-declick').addEventListener('mouseup', function() {
        clearTimeout(declickTimeout);
        clearInterval(declickTimeout);
    });
</script>
@endsection