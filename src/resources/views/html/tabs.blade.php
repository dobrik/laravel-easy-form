<h4>{{ \Illuminate\Support\Arr::pull($attributes, 'title') }}</h4>
<div class="nav-tabs-custom">
    @if(count($tabs) > 1)
        <ul @forelse($attributes as $attribute => $value) {{ $attribute }}="{{ $value }}" @empty @endforelse>
        @forelse($tabs as $key => $tab)
            <li class="@if($key === 0) active @endif">
                <a data-toggle="tab" aria-expanded="true"
                   href="#{{ $tab->attributes['id'] }}">{{ $tab->attributes['title'] }}</a>
            </li>
        @empty
        @endforelse
        </ul>
    @endif
        <div class="tab-content">
            @forelse($tabs as $key => $tab)
                {!! $tab !!}
            @empty
            @endforelse
        </div>
</div>
