@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div style="font-size: 13px !important;color: rgb(255, 51, 51);margin-top: 20px;">
            {{ __('Whoops! Something went wrong.') }}
            @foreach ($errors->all() as $error)
                <p style="font-size: 13px !important;color: rgb(255, 51, 51);margin-top: 5px;">{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
