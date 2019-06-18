<div class="row">
    <div class="col-md-12 form-group">
        <label class="btn btn-default">
            <p><b>Image</b></p>
            <p><b>{{ $attributes['label'] }}</b></p>
            <img id="{{ $id = $object->getId() }}"
                 src="{{  asset($object->getValue()?$object->getValue():'vendor/easy_form/assets/images/no_image.png') }}"
                 style="max-height: 150px; max-width: 150px;"/>
            <input type="file" id="{{ $id }}_input" name="{{ $attributes['name'] }}" hidden>
            @if($object->getValue())
                <p>
                    <label for="{{$object->getName()}}_delete">Delete image</label>
                    <input type="checkbox" value="1" name="{{$object->getName()}}_delete">
                </p>
            @endif
        </label>
    </div>
    @if($errors->has(arrayToDot($attributes['name'])))
        <div class="input_error text-danger image">{{ $errors->first(arrayToDot($attributes['name'])) }}</div>
    @endif
</div>
<script>
    document.getElementById("{{$id}}_input").onchange = function () {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('img#{{ $id }}').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        readURL(document.getElementById("{{$id}}_input"));
    };
</script>