@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-header">{{ __('Il tuo diario') }}</div>

                    <div class="card-body">
                        Benvenuto Al TheoryPanel !

                        <br>
                        <br>

                        @guest
                            Per usare l'app devi <a href="{{ route('login') }}">Accedere</a>
                            <br>
                            Oppure <a href="{{ route('register') }}">Registrarti</a>
                        @endguest

                        @auth
                            Accedi al tuo <a href="{{ route('home') }}">Diario</a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
