@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- post message card -->
                <div id="alert" class="mb-5"></div>

                <div class="card mb-5">
                    <div class="card-header">{{ __('Il Tuo Profilo') }}</div>

                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-2">
                                <img id="avatarPreview" style="max-width: 100px; max-height: 100px; border-radius: 50%;"  src="{{ Auth::user()->avatar }}" alt="{{ __('Avatar Image') }}">
                            </div>

                            <div class="col-10 d-flex flex-column align-items-end" style="text-align: left;">
                                <div>
                                    {{ Auth::user()->name }}
                                </div>

                                <div>
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2"></div>
                            <div class="col-10">

                            </div>
                        </div>

                    </div>
                </div>
                <!--/ post message card -->

            </div>
        </div>
    </div>
@endsection
