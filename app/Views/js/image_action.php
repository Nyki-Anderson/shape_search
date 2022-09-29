<script>
    
    $(document).ready(function() { 
        var csrfName = "<?= csrf_token(); ?>"; 
        var csrfHash = "<?= csrf_hash(); ?>"; 
        var viewkey = "<?= esc($image->viewkey); ?>";

        // If user views image 
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>/images/view_image/<?= $image->viewkey;?>",
            dataType: "JSON",
            data: {
                [csrfName]: csrfHash,
                "viewkey": viewkey,
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
                $('span.viewCount').text(res.views);
            }
        });

        // if the user clicks on the like button
        $(".like-button").on("click", function() {
            var viewkey = $(this).data("viewkey");
            $clicked_btn = $(this);

            if ($clicked_btn.hasClass("fa-thumbs-o-up")) {
                action = "like";
            } else if ($clicked_btn.hasClass("fa-thumbs-up")) {
                action = "unlike";
            }

            $.ajax({
                url: "<?= base_url(); ?>/images/view_image/<?= $image->viewkey;?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    [csrfName]: csrfHash,
                    "action": action,
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

                    if (action == "like") {
                        $clicked_btn.removeClass("fa-thumbs-o-up");
                        $clicked_btn.addClass("fa-thumbs-up");
                    } else if (action == "unlike") {
                        $clicked_btn.removeClass("fa-thumbs-up");
                        $clicked_btn.addClass("fa-thumbs-o-up");
                    }

                    // display number of likes and dislikes
                    $clicked_btn.siblings('span.likeCount').text(res.likes);
                    $clicked_btn.siblings('span.dislikeCount').text(res.dislikes);

                    // Change button styling of the other button if user is reacting the second time to image
                    $clicked_btn.siblings("i.fa-thumbs-down").removeClass("fa-thumbs-down").addClass("fa-thumbs-o-down");
                }
            });
        });
        // If the user clicks on the dislike button
        $(".dislike-button").on("click", function() {
            var viewkey = $(this).data("viewkey");
            $clicked_btn = $(this);

            if ($clicked_btn.hasClass("fa-thumbs-o-down")) {
                action = "dislike";
            } else if ($clicked_btn.hasClass("fa-thumbs-down")) {
                action = "undislike";
            }

            $.ajax({
                url: "<?= base_url(); ?>/images/view_image/<?= $image->viewkey;?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    [csrfName]: csrfHash,
                    "action": action,
                    "viewkey": viewkey
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(data) {
                    var res = data;

                    // Update CSRF hash
                    csrfName = res.csrfName;
                    csrfHash = res.csrfHash;

                    if (action == "dislike") {
                        $clicked_btn.removeClass("fa-thumbs-o-down");
                        $clicked_btn.addClass("fa-thumbs-down");
                    } else if (action == "undislike") {
                        $clicked_btn.removeClass("fa-thumbs-down");
                        $clicked_btn.addClass("fa-thumbs-o-down");
                    }

                    // display number of likes and dislikes
                    $clicked_btn.siblings('span.likeCount').text(res.likes);
                    $clicked_btn.siblings('span.dislikeCount').text(res.dislikes);

                    // Change button styling of the other button if user is reacting the second time to image
                    $clicked_btn.siblings("i.fa-thumbs-up").removeClass("fa-thumbs-up").addClass("fa-thumbs-o-up");
                }
            });
        });
        // if the user clicks on the favorite button
        $(".favorite-button").on("click", function() {
            var viewkey = $(this).data("viewkey");
            $clicked_btn = $(this);

            if ($clicked_btn.hasClass("fa-regular fa-heart")) {
                action = "favorite";
            } else if ($clicked_btn.hasClass("fa-solid fa-heart")) {
                action = "unfavorite";
            }

            $.ajax({
                url: "<?= base_url(); ?>/images/view_image/<?= $image->viewkey;?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    [csrfName]: csrfHash,
                    "action": action,
                    "viewkey": viewkey
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(data) {
                    var res = data;

                    // Update CSRF hash
                    csrfName = res.csrfName;
                    csrfHash = res.csrfHash;

                    if (action == "favorite") {
                        $clicked_btn.removeClass("fa-regular fa-heart");
                        $clicked_btn.addClass("fa-solid fa-heart");
                    } else if (action == "unfavorite") {
                        $clicked_btn.removeClass("fa-solid fa-heart");
                        $clicked_btn.addClass("fa-regular fa-heart");
                    }

                    // display number of favorites
                    $clicked_btn.siblings('span.favoriteCount').text(res.favorites);
                }
            });
        });
    });
</script>