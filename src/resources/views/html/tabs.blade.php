<h4>{{ array_pull($attributes, 'label') }}</h4>
<div @forelse($attributes as $attribute => $value) {{ $attribute }}="{{ $value }}" @empty @endforelse >
<ul class="nav nav-tabs">
    @forelse($tabs as $key => $tab)
        <li @if(!empty($tab->attributes['class']) && str_contains($tab->attributes['class'], 'active')) class="active" @endif>
            <a data-toggle="tab" @if(!empty($tab->attributes['class']) && str_contains($tab->attributes['class'], 'active')) aria-expanded="true"
               @else aria-expanded="false"
               @endif href="#{{ $tab->attributes['id'] }}">{{ $tab->attributes['title'] }}</a>
        </li>
    @empty
    @endforelse
</ul>
<div class="tab-content">
    @forelse($tabs as $tab)
        {!! $tab !!}
    @empty
    @endforelse
</div>
</div>
