<div class="container-fluid">
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-12" id="{{ $id = $object->getId() }}">
        <form action="{{ $action }}" method="{{ $method }}"
              enctype="multipart/form-data">
            <div class="col-md-12">{!! $buttons !!}</div>
            {!! csrf_field() !!}
            {!! $form !!}
            @if(in_array(strtolower($method), ['patch', 'put', 'delete']))
                @method($method)
            @endif
        </form>
        @if($object->getAjax())
            <script>
                $().ready(function () {
                    $('div#{{ $id }} form input[type="submit"]').click(function (e) {
                        $.ajax({
                            url: $('div#{{ $id }} form').attr('action'),
                            method: '{{ strtolower($method) }}',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: $('div#{{ $id }} form'),
                            success: function (response) {
                                {{--$('div[data-id="{{ $attributes['id'] }}"]').replaceWith(response);--}}
                            }
                        });

                        e.preventDefault();
                        return false;
                    })
                })
            </script>
        @endif
    </div>
</div>