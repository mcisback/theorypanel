@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- post message card -->
            <div id="alert" class="mb-5"></div>

            <div class="card mb-5">
                <div class="card-header">{{ __('Profilo') }}</div>

                <div class="card-body">
                    <div>
                        <form id="updateForm" action="#updateProfile" class="p-4 pb-0">
                            <div class="form-group row mb-3">
                                <label for="avatar" class="col-sm-2 col-form-label">
                                    <img id="avatarPreview" style="max-width: 100px; max-height: 100px; border-radius: 50%;" src="{{ Auth::user()->avatar }}" alt="{{ __('Avatar Image') }}" />
                                </label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="avatarFile" name="avatarFile">
                                        <label class="custom-file-label" for="customFile">{{ __('Scegli Avatar') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">{{ __('Nome') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="{{ __('Nome') }}" required value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" placeholder="{{ __('Email') }}" required value="{{ Auth::user()->email }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" placeholder="{{ __('Password') }}" required value="{{ Auth::user()->password }}">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password_confirmation" class="col-sm-2 col-form-label">{{ __('Conferma Password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="{{ __('Conferma Password') }}" required value="{{ Auth::user()->password }}">
                                </div>
                            </div>

                            <input type="hidden" name="avatar" id="avatar" value="{{ Auth::user()->avatar }}">

                            <div class="row">
                                <button type="submit" class="btn btn-primary">{{__('Aggiorna')}}</button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <form id="destroyForm" action="{{ route('profile.destroy', Auth::id()) }}" class="p-4 pb-0" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="form-group row">
                                <button type="submit" class="btn btn-danger">{{__('Cancella Profilo')}}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!--/ post message card -->

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module">
        const headers = {
            'Accept': 'application/json',
            'X-CSFR-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer {{ Auth::user()->getDefaultApiToken() }}'
        }

        async function updateProfile() {
            const password = $("#password").val()
            const password_confirmation = $("#password_confirmation").val()

            $("#alert").html(``)

            if( password !== password_confirmation ) {
                bsAlert(false, '{{__('Le password non corrispondono')}}');

                return false
            }

            axios.put("{{ route('api.profile.update', Auth::id()) }}", {
                name: $("#name").val(),
                password: $("#password").val(),
                password_confirmation: $("#password_confirmation").val(),
                avatar: $("#avatar").val(),
            },
            {
                headers
            }).then(res => {
                console.log(res.data)

                bsAlert(res.data.success, res.data.message);
            }).then(error => {
                console.error(error)

                bsAlert(false, error.message);
            })
        }

        function handleFiles() {
            $("#alert").html(``)

            const preview = document.querySelector("#avatarPreview");
            const file = document.querySelector("input[type=file]").files[0];

            function readAndPreview(file) {
                // Make sure `file.name` matches our extensions criteria

                // File is >= 16MiB
                if(file.size >= 16777215) {
                    bsAlert(false, "Sono ammessi file di dimensione minore di 16MB")

                    return
                }

                if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    bsAlert(false, 'Solo jpeg, png e gif sono valide')

                    return false;
                }

                const reader = new FileReader();

                reader.addEventListener(
                    "load",
                    () => {
                        const imageDataURI = reader.result
                        console.log('New Avatar: ', imageDataURI)

                        preview.src = imageDataURI;

                        $("#avatar").val(imageDataURI)
                    },
                    false,
                );

                reader.readAsDataURL(file);
            }

            readAndPreview(file);
        }

        $(document).ready(async () => {
            $("#avatarFile").on("change", handleFiles);

            $("#updateForm").on("submit", ( event ) => {
                event.preventDefault();

                updateProfile();
            });

            $("#destroyForm").on("submit", ( event ) => {
                event.preventDefault();

                if (confirm("Sei sicuro di voler cancellare il tuo profilo ? Perderai tutti i tuoi dati") === false) {
                    return false;
                }

                event.target.submit();
            })

        })


    </script>
@endpush
