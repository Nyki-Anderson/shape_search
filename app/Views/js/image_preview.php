<script>
    function onFileUpload(input, id) {
        id = id || '#upload-preview';

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $(id).attr('src', e.target.result).width(300)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>