<{{ $type }} @forelse($attributes as $attribute => $value) {{ $attribute }}="{{ $value }}" @empty @endforelse>
    {!! $content !!}
</{{ $type }}>
