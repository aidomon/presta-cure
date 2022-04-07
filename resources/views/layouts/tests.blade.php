<x-dashboard>

    <h3>Available security tests</h3>
    <hr>

    <section id="tests-list">
        @if ($tests->count() != 0)
            @foreach ($tests as $test)
                <div id="{{ strtolower(str_replace(' ', '', $test->name)) }}">
                    <h4>{{ $test->name }}</h4>
                    <p>{{ $test->description }}</p>
                    <a href="{{ $test->fix_link }}">Fix link</a>
                </div>
            @endforeach
        @else
            <p>No tests currently available</p>
        @endif

    </section>

</x-dashboard>
