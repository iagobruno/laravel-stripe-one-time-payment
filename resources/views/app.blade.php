<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbo-cache-control" content="no-preview">

    <title>{{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    {{-- <script src="{{ mix('/js/app.js') }}" async defer></script> --}}
</head>
<body>
    <main>
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="d-flex align-items-center gap-4 w-100">
            <div>
                @can('get-book')
                    <div class="badge bg-success mb-2">&radic; Comprado</div>
                @else
                    <strong class="h5 d-block">Compre o livro</strong>
                @endcan
                <h2>JavaScript Eloquente - 2ª edição</h2>
                <p class="text-muted">Uma moderna introdução ao JavaScript, programação e maravilhas digitais.</p>
                @cannot('get-book')
                    <div class="h5">R$ 79.99</div>
                @endcannot

                <div class="mt-4">
                    @can('get-book')
                        <form action="{{ route('download') }}" method="POST" target="_blank">
                            @csrf
                            <button type="submit" class="btn btn-primary">&darr; Download</button>
                        </form>
                    @elseif (!Auth::check())
                        <form action="{{ route('auth') }}" method="POST">
                            @csrf
                            <input
                                type="email"
                                name="email"
                                class="form-control mb-3"
                                value="fake-user@gmail.com"
                                placeholder="your@email.com"
                                required
                            >
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    @else
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Finalizar compra</button>
                        </form>
                        <small class="text-muted text-center mt-2 d-block w-75 m-auto">Você será redirecionado para a página de checkout do Stripe.</small>
                    @endcan
                </div>
            </div>

            <img src="/imgs/book-cover.png" class="cover" />
        </div>
    </main>
</body>
</html>
