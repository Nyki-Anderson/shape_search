<script>
    $(document).ready(function() {
        var csrfName = "<?= csrf_token(); ?>";
        var csrfHash = "<?= csrf_hash(); ?>";

        $('.album-list').on('change', 'input[type=checkbox]', function() {
            const album = $(this).val();
            const albumId = $(this).data('id');
            const viewkey = $(this).closest('[data-viewkey]').data('viewkey');

            if (!viewkey || !album) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>/users/members/manage_uploads",
                dataType: "JSON",
                data: {
                    [csrfName]: csrfHash,
                    "album_name": album,
                    "viewkey": viewkey,
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(data) {
                    var res = data;

                    // Update CSRF hash
                    csrfName = res.csrfName;
                    csrfHash = res.csrfHash;

                    // Display new album name in table
                    document.getElementById('viewkey-'+viewkey).innerHTML = album;

                    // Unset all checkbox buttons
                    $('input[name=album_checkbox]').prop('checked', false);

                    alert(res.message);
                }
            });
        });

        $(document).on('click', '.new-album-button', function() {
            const viewkey = $(this).closest('[data-viewkey]').data('viewkey');
            const id = $(this).closest('[data-id]').data('id');
            const newAlbum = $(this).siblings('[type=text]').val();

            // Checks if album name is empty
            if (newAlbum === '') {
                alert('Please enter an album name');
                return false;
            }

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>/users/members/manage_uploads",
                dataType: "JSON",
                data: {
                    [csrfName]: csrfHash,
                    "album_name": newAlbum,
                    "viewkey": viewkey,
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(data) {
                    var res = data;

                    // Update CSRF hash
                    csrfName = res.csrfName;
                    csrfHash = res.csrfHash;

                    // Display new album name in table
                    document.getElementById('viewkey-'+viewkey).innerHTML =  newAlbum;

                    // Add new album name to all dropdown checkbox buttons
                    addNewcheckboxItem(viewkey, newAlbum, id);

                    // Unset 'New Album' checkbox button and clear input text
                    $('input[type=checkbox]').prop('checked', false);
                    document.getElementById('txt-'+id).value = '';

                    alert(res.message);
                }
            });
        });
    });

    function addNewcheckboxItem(viewkey, album, id) {
        let someId = uuidv4();
        alert(someId);
        const container = document.querySelectorAll('.album-list');

        // Create new album checkbox in dropdown menu
        const label = document.createElement('label');
        const checkbox = document.createElement('input');
        const spanCheck = document.createElement('span');
        const spanTitle = document.createElement('span');

        label.setAttribute('class', 'album-select checkbox');
        label.setAttribute('htmlFor', 'album-checkbox');
        label.innerHTML += ' <i class="fa-solid fa-xmark"></i>';

        checkbox.setAttribute ('type', 'checkbox');
        checkbox.setAttribute('name', 'album[]');
        checkbox.setAttribute('class', 'album-checkbox');
        checkbox.setAttribute('value', album);
        checkbox.setAttribute('id', 'checkbox');

        spanTitle.setAttribute('class', 'album-title');
        spanTitle.innerHTML += album
        spanCheck.setAttribute('class', 'checkmark');

        label.appendChild(spanTitle);
        label.appendChild(checkbox);
        label.appendChild(spanCheck);

        $(container).append(label);

        // Sorts checkbox options with added album
        sortNewCheckbox();
    }

    function sortNewCheckbox() {

    }

    function getAlbumArray() {

    }
</script>