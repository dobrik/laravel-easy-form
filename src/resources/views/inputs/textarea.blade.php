<div class="form-group">
    @if($label = array_pull($attributes ,'label'))
        <label for="{{ $attributes['id'] or $attributes['name'] }}">{{ $label }}</label>
    @endif
    <textarea @forelse($attributes as $attr_name => $attr_value) {{ $attr_name }}="{{ $attr_value }}" @empty @endforelse>{!! $value !!}</textarea>
        @if($errors->has(arrayToDot($attributes['name'])))
            <div class="input_error text-danger textarea">{{ $errors->first(arrayToDot($attributes['name'])) }}</div>
        @endif
</div>