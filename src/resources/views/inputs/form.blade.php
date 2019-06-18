<div class="container-fluid">
    <div class="col-md-12" data-id="{{ $attributes['id'] }}">
        <form action="{{ $action }}" method="{{ $method }}"
              enctype="multipart/form-data">
            <div class="col-md-12">{!! $buttons !!}</div>
            {!! csrf_field() !!}
            {!! $form !!}
            @if(in_array(strtolower($method), ['patch', 'put', 'delete']))
                @method($method)
            @endif
        </form>
        @if($ajax == true)
            <script>
                $().ready(function () {
                    $('div[data-id="{{ $attributes['id'] }}"]>form input[type="submit"]').click(function (e) {

                        $.ajax({
                            url: $('div[data-id="{{ $attributes['id'] }}"]>form').attr('action'),
                            method: '{{ strtolower($method) }}',
                            dataType: 'html',
                            data: $('div[data-id="{{ $attributes['id'] }}"]>form').serialize(),
                            success: function (response) {
                                $('div[data-id="{{ $attributes['id'] }}"]').replaceWith(response);
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