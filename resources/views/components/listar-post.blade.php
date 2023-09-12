<div>
    @if ($posts->count())
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
            @foreach ($posts as $post )
                <div>
                    <a href=" {{ route('posts.show',[ 'user' => $post->user,'post' => $post ]) }} ">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links() }}
        </div>
    @else
        <p>No hay Posts</p>
    @endif
</div>
