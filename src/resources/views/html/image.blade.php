<div class="{{ $object->pullWrapperClass() }}">
    <label class="btn">
        <p><b>Image</b></p>
        <p><b>{{ $object->getTitle() }}</b></p>
        <img id="{{ $id = $object->getId() }}"
             src="{{  asset($object->getValue()?$object->getValue():'vendor/easy_form/assets/images/no_image.png') }}"
             style="max-height: 150px; max-width: 150px;"/>
        <p>
            <a href="#" onclick="document.getElementById('{{ $id }}_input').click(); event.preventDefault();"
               class="btn btn-primary">
                Load Image
            </a>
        </p>
        <input class="hidden" style="display: none;" type="file" id="{{ $id }}_input" name="{{ $object->getName() }}">
        @if($object->getValue())
            <p>
                <label for="{{$object->getName()}}_delete">Delete image</label>
                <input type="checkbox" value="1" name="{{$object->getName()}}_delete">
            </p>
        @endif
    </label>
</div>
@if($errors->has(arrayToDot($object->getName())))
    <div class="input_error text-danger image">{{ $errors->first(arrayToDot($object->getName())) }}</div>
@endif
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
