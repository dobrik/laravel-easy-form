<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        function select2_sortable($select2) {
            var ul = $select2.next('.select2-container').first('ul.select2-selection__rendered');
            @if($object->getParent()->getValue())
            @foreach($object->getParent()->getValue()->sortBy('pivot.order') as $value)
            prependOption($select2, {{ $value->id }})
            @endforeach
            @endif
            ul.sortable({
                placeholder: 'ui-state-highlight',
                forcePlaceholderSize: true,
                items: 'li:not(.select2-search__field)',
                tolerance: 'pointer',
                stop: function () {
                    $($(ul).find('.select2-selection__choice').get().reverse()).each(function () {
                        var id = $(this).data('data').id;
                        prependOption($select2, id);
                    });
                }
            });
        }

        function prependOption($select2, value) {
            var option = $select2.find('option[value="' + value + '"]')[0];
            $select2.prepend(option);
        }

        select2_sortable($('#{{ $object->getParent()->getId() }}'));
    });
</script>
