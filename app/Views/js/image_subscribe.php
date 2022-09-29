<script>
    $(document).ready(function() {  
        var csrfName = "<?= csrf_token(); ?>";
        var csrfHash = "<?= csrf_hash(); ?>"; 

    // If user clicks the subscribe button
        $(".subscribe-button").on("click", function (event) {
            $clicked_btn = $(this);
            let $icon = $clicked_btn.find('i').first();
            var userProfile = $(this).data("user");

            if ($icon.hasClass("fa-solid fa-rss")) {
                action = "subscribe";
            } else if ($icon.hasClass("fa-solid fa-user-check")) {
                action = "unsubscribe";
            }

            $.ajax ({
                url: "<?= base_url(); ?>/images/view_image/<?= $image->viewkey;?>",
                type: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    "action": action,
                    "user_profile": userProfile,
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(data) {
                    var res = data;
                    csrfName = res.csrfName;
                    csrfHash = res.csrfHash;

                    if (action == "subscribe") {
                        $icon.removeClass("fa-solid fa-rss");
                        $('.subscribe-button').html('<i class="fa-solid fa-user-check"></i> Subscribed');
                    } else if (action == "unsubscribe") {
                        $icon.removeClass("fa-solid fa-user-check");
                        $('.subscribe-button').html('<i class="fa-solid fa-rss"></i> Subscribe');
                    }
                }
            });
        });
    });
</script>