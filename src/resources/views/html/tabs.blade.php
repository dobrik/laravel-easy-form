<h4>{{ array_pull($attributes, 'label') }}</h4>
<ul @forelse($attributes as $attribute => $value) {{ $attribute }}="{{ $value }}" @empty @endforelse role="tablist">
    @forelse($tabs as $key => $tab)
        <li class="nav-item">
            <a data-toggle="tab" class="nav-link  @if($key === 0) active @endif" aria-expanded="true" aria-expanded="false" href="#{{ $tab->attributes['id'] }}">{{ $tab->attributes['title'] }}</a>
        </li>
    @empty
    @endforelse
</ul>
<div class="tab-content">
    @forelse($tabs as $key => $tab)
        {!! $tab !!}
    @empty
    @endforelse
</div>
