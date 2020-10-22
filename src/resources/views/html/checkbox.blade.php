<div class="{{ $object->pullWrapperClass() }}">
    @if($label = Illuminate\Support\Arr::pull($attributes ,'title'))
        <label for="{{ $attributes['id'] or $attributes['name'] }}">{{ $label }}</label>
    @endif
    <input type="checkbox" @forelse($attributes as $attr_name => $attr_value) {{ $attr_name }}="{{ $attr_value }}" @empty @endforelse >
    @if($errors->has(arrayToDot($attributes['name'])))
        <div class="text-danger input_error {{ $attributes['name'] }}">{{ $errors->first(arrayToDot($attributes['name'])) }}</div>
    @endif
</div>
