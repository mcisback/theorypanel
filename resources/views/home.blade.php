@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- post message card -->
            <div class="card mb-5">
                <div class="card-header">{{ __('Il tuo diario') }}</div>

                <div class="card-body">

                    <form id="postForm" action="#sendpost" class="p-4 pb-0">
                        <div class="row mb-3">
                            <textarea name="message" id="message" cols="30" rows="10" placeholder="A cosa stai pensando oggi ?" class="form-control" required></textarea>
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-primary">Invia</button>
                        </div>
                    </form>

                </div>
            </div>
            <!--/ post message card -->

            <div id="posts">
                @foreach($posts as $post)
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center flex-row">
                            <div class="w-25">
                                <div class="avatar my--avatar-small">
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ __('Immagine Utente') }}"/>
                                </div>
                            </div>
                            <div class="w-75" style="text-align: right">
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y h:m') }}
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $post->message }}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module">
        const headers = {
            'Accept': 'application/json',
            'X-CSFR-TOKEN': '{{ csrf_token() }}',
            'Authorization': 'Bearer {{ Auth::user()->getDefaultApiToken() }}'
        }

        async function sendPost() {
            axios.post("{{ route('api.posts.store') }}",{
                message: $("#message").val()
            },
            {
                headers
            }).then(res => {
                console.log(res.data)

                updatePosts()
            })
        }

        async function updatePosts() {
            const posts = await axios.get("{{ route('api.posts.findbyuser') }}", {
                headers
            }).then(response => response.data.data)

            $("#posts").html(``)

            console.log('POSTS: ', posts)

            posts.forEach(post => {
                document.querySelector("#posts").innerHTML += `
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center flex-row">
                            <div class="w-25">
                                <div class="avatar my--avatar-small">
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ __('Immagine Utente') }}"/>
                                </div>
                            </div>
                            <div class="w-75" style="text-align: right">
                                ${post.created_at}
                            </div>
                        </div>

                        <div class="card-body">
                            ${post.message}
                        </div>
                    </div>
`
            })
        }

        $(document).ready(async () => {
            $("#postForm").on("submit", ( event ) => {
                event.preventDefault();

                sendPost();
            });
        })


    </script>
@endpush
