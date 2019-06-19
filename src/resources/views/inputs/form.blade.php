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
    <div class="col-md-12" id="{{ $object->getId() }}">
        <form action="{{ $action }}" method="{{ $method }}"
              enctype="multipart/form-data">
            <div class="col-md-12">{!! $buttons !!}</div>
            {!! csrf_field() !!}
            {!! $form !!}
            @if(in_array(strtolower($method), ['patch', 'put', 'delete']))
                @method($method)
            @endif
        </form>
    </div>
</div>