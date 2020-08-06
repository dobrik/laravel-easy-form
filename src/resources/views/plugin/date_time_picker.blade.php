<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('#{{ $object->getParent()->getName() }}').datetimepicker();
    });
</script>
