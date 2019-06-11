<button @forelse($attributes as $key => $value) {{$key}}="{{$value}}" @empty @endforelse>{{ $title }}</button>
