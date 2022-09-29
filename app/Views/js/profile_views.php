<script>
    $(document).ready(function() { 
        var csrfName = "<?= csrf_token(); ?>"; 
        var csrfHash = "<?= csrf_hash(); ?>"; 
        
        // If user views profile 
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>/users/members/view_profile/<?= $profile->username;?>",
            dataType: "JSON",
            data: {
                [csrfName]: csrfHash,
                "action": 'view',
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(data) {
                var res = data;

                // Update CSRF hash
                csrfName = res.csrfName;
                csrfHash = res.csrfHash;

                // display number of views
                $('#profileCount').html(res.viewCount);
            }
        });
    });
</script>