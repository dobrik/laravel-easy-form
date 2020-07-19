<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('#{{ $object->getParent()->getId() }}').select2();
    });
</script>
