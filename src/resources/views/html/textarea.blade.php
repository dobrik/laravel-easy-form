<div class="{{ $object->pullWrapperClass() }}">
    @if($label = $object->pullTitle())
        <label for="{{ $attributes['id'] ?? $attributes['name'] }}">{{ $label }}</label>
    @endif
    <textarea @forelse($attributes as $attr_name => $attr_value) {{ $attr_name }}="{{ $attr_value }}" @empty @endforelse>{!! $value !!}</textarea>
        @if($errors->has(arrayToDot($attributes['name'])))
            <div class="input_error text-danger textarea">{{ $errors->first(arrayToDot($attributes['name'])) }}</div>
        @endif
</div>
