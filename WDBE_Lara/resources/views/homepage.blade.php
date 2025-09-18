<!doctype html>
<html>
<body>
    @if(session('success')) <div>{{ session('success') }}</div> @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <input name="title" value="{{ old('title') }}" placeholder="Title">
        @error('title') <div>{{ $message }}</div> @enderror

        <textarea name="content" placeholder="Content">{{ old('content') }}</textarea>
        @error('content') <div>{{ $message }}</div> @enderror

        <button type="submit">Save</button>
    </form>

    <h2>All posts</h2>
    @foreach($posts as $post)
        <article>
            <h3>{{ $post->title }}</h3>
            <p>{{ \Illuminate\Support\Str::limit($post->content, 150) }}</p>
        </article>
    @endforeach

    {{ $posts->links() }} {{-- pagination links --}}
</body>
</html>
