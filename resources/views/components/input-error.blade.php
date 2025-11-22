@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }} style="color: #dc2626;">
        @foreach ((array) $messages as $message)
            <li style="color: #dc2626; font-weight: 500;">{{ $message }}</li>
        @endforeach
    </ul>
@endif
