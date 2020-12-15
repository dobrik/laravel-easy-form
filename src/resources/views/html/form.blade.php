<div class="box box-default">
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="box-header with-border" id="{{ $object->getId() }}">
        <form action="{{ $action }}" method="{{ $method }}"
        @forelse($attributes as $attr_name => $attr_value) {{ $attr_name }}="{{ $attr_value }}" @empty @endforelse>
            {!! csrf_field() !!}
            {!! $form !!}
            @if(in_array(strtolower($method), ['patch', 'put', 'delete']))
                @method($method)
            @endif
        </form>
    </div>
</div>
