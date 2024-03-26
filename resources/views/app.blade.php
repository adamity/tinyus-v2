@extends('layout')

@section('content')
<div id="error-alert" class="alert alert-danger fixed-top text-center mx-md-5 my-md-3 border border-3 border-dark" role="alert" style="display: none"></div>
<div id="success-alert" class="alert alert-success fixed-top text-center mx-md-5 my-md-3 border border-3 border-dark" role="alert" style="display: none"></div>

<div class="bg-milk-punch-highland border-bottom border-3 border-dark">
    <div class="bg-noise">
        <div class="container vh-lg-85">
            <div class="row h-100 py-5">
                <div class="col-12 col-lg-8 order-2 order-lg-1 h-100">
                    <div class="d-flex flex-column justify-content-center text-center text-lg-start h-100">
                        <p class="fw-bold fs-1 ff-fugaz">The only URL shortener you'll ever need, probably...</p>
                        <p class="lead fs-4 mb-5 ff-fredoka">Squeezing long URLs into itty-bitty ones because life's too short for long web addresses! ✨😜</p>
                        <a href="#shorten">
                            <button class="btn btn-lg btn-amber border border-3 border-dark px-5 rounded-5">Go Tiny! 🤏</button>
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

<div id="shorten" class="bg-highland bg-noise border-bottom border-3 border-dark min-vh-100">
    <div class="container py-5">
        <div class="card bg-perfume border border-3 border-dark shadow-none vh-lg-80 p-md-4">
            <div class="card-header px-0 px-md-3 border-0">
                <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-start justify-content-center justify-content-lg-between">
                    <p class="fw-bold fs-3 ff-fugaz m-0">Shorten URLs 🔮</p>

                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex">
                                <button id="button-inclick" type="button" class="btn btn-sm btn-warning border border-3 border-dark rounded-5 shadow-none" onclick="updateMaxClick(-1)">➖</button>
                                <input id="max-click" type="text" class="form-control form-control-sm border border-3 border-dark rounded-5 mx-1 w-100px" placeholder="∞" aria-label="∞" value="" disabled>
                                <button id="button-declick" type="button" class="btn btn-sm btn-warning border border-3 border-dark rounded-5 shadow-none" onclick="updateMaxClick(1)">➕</button>
                            </div>
                            <p class="small m-0 ff-fredoka">Max Click</p>
                        </div>

                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex">
                                <input id="expiry-date" type="date" class="form-control form-control-sm border border-3 border-dark rounded-5 mx-1 w-200px" placeholder="Expiry Date" aria-label="Expiry Date" value="" min="{{ date('Y-m-d') }}">
                                <button id="button-clean" type="button" class="btn btn-sm btn-danger border border-3 border-dark rounded-5 shadow-none" onclick="document.getElementById('expiry-date').value = ''; document.getElementById('max-click').value = ''">🗑️</button>
                            </div>
                            <p class="small m-0 ff-fredoka">Expiry Date</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body scroller p-2 p-md-3 p-lg-auto vh-80 vh-lg-auto">
                <div class="d-flex mb-3">
                    <input name="url[]" type="text" class="form-control form-control-lg border border-3 border-dark rounded-5" placeholder="https://example.com/this-url-is-too-long" aria-label="https://example.com/this-url-is-too-long">
                    <button id="button-add" type="button" class="btn btn-warning border border-3 border-dark rounded-5 shadow-none ms-1 ms-md-3 px-3" onclick="addInput()">➕</button>
                </div>
                <div id="addon-container"></div>
            </div>

            <div class="card-footer px-0 px-md-3 border-0 text-center">
                <button type="button" class="btn btn-lg btn-amber border border-3 border-dark px-5 rounded-5 js-input-wrapper" onclick="submit()">Go Tiny! 🤏</button>
                <input id="shortened-url" type="text" class="form-control form-control-lg border border-3 border-dark rounded-5 js-output-wrapper" placeholder="https://example.com/shortened-link-here" aria-label="https://example.com/shortened-link-here" disabled>
                <button type="button" class="btn btn-lg btn-amber border border-3 border-dark px-5 rounded-5 mt-3 js-output-wrapper" onclick="copyToClipboard()">Copy URL 📋</button>
            </div>
        </div>
    </div>
</div>

<script>
    let inclickTimeout;
    let declickTimeout;

    document.querySelectorAll('.js-output-wrapper').forEach(wrapper => {
        wrapper.classList.add('d-none');
    });

    document.getElementById('expiry-date').value = '';
    document.getElementById('max-click').value = '';
    document.querySelectorAll('input[name="url[]"]').forEach(url => {
        url.value = '';
    });

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

    function updateMaxClick(value) {
        const maxClick = document.getElementById('max-click');
        const currentMaxClick = maxClick.value == '' ? 0 : parseInt(maxClick.value);
        const newMaxClick = currentMaxClick + value;

        maxClick.value = newMaxClick <= 0 ? '' : newMaxClick;
    }

    function addInput() {
        const container = document.getElementById('addon-container');

        const div = document.createElement('div');
        const input = document.createElement('input');
        const button = document.createElement('button');

        div.className = 'd-flex mb-3';

        input.name = 'url[]';
        input.type = 'text';
        input.className = 'form-control form-control-lg border border-3 border-dark rounded-5';
        input.placeholder = 'https://example.com/this-url-is-too-long';
        input.setAttribute('aria-label', 'https://example.com/this-url-is-too-long');

        button.className = 'btn btn-danger border border-3 border-dark rounded-5 shadow-none ms-1 ms-md-3 px-3 js-button-delete';
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

    function validateUrl(url) {
        const regex = /^(http|https):\/\/[^ "]+$/;
        const appUrl = '{{ env('APP_URL') }}';
        return regex.test(url) && !url.includes(appUrl);
    }

    function showAlert(message, type) {
        document.getElementById(`${type}-alert`).innerHTML = message;
        document.getElementById(`${type}-alert`).setAttribute('style', 'display: block');

        setTimeout(function() {
            document.getElementById(`${type}-alert`).innerHTML = '';
            document.getElementById(`${type}-alert`).setAttribute('style', 'display: none');
        }, 3000);
    }

    function copyToClipboard() {
        var $temp = $("<input>");
        $("body").append($temp);

        $temp.val($("#shortened-url").val()).select();
        document.execCommand("copy");

        $temp.remove();
        showAlert('URL copied to clipboard', 'success');
    }

    function submit() {
        const request = {
            urls: [],
            max_clicks: document.getElementById('max-click').value,
            expired_at: document.querySelector('input[type="date"]').value
        };

        let valid = true;
        document.querySelectorAll('input[name="url[]"]').forEach(url => {
            url.setAttribute('style', 'border-color: ""');
            if (!validateUrl(url.value)) {
                url.setAttribute('style', 'border-color: red !important');
                valid = false;
            } else if (url.value != '') {
                request.urls.push(url.value);
            }
        });

        if (request.urls.length == 0) {
            showAlert('Please enter at least one URL', 'error');
            return;
        }

        if (!valid) {
            showAlert('Please enter a valid URL', 'error');
            return;
        }

        $.ajax({
            url: '{{ env('APP_URL') }}/api/v1/shorten',
            type: 'POST',
            data: JSON.stringify(request),
            contentType: 'application/json',
            success: function(response) {
                showAlert('URLs shortened successfully', 'success');
                document.getElementById('shortened-url').value = response.data.shortened_url;

                document.querySelectorAll('.js-input-wrapper').forEach(wrapper => {
                    wrapper.classList.add('d-none');
                });

                document.querySelectorAll('.js-output-wrapper').forEach(wrapper => {
                    wrapper.classList.remove('d-none');
                });

                document.getElementById('max-click').disabled = true;
                document.getElementById('expiry-date').disabled = true;

                document.getElementById('button-inclick').disabled = true;
                document.getElementById('button-declick').disabled = true;

                document.getElementById('button-clean').disabled = true;
                document.getElementById('button-add').disabled = true;

                document.querySelectorAll('input[name="url[]"]').forEach(url => {
                    url.disabled = true;
                });

                document.querySelectorAll('.js-button-delete').forEach(button => {
                    button.disabled = true;
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>
@endsection