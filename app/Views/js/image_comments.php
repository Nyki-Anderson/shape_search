<script>
    $(document).ready(function () {
        var csrfName = "<?= csrf_token(); ?>";
        var csrfHash = "<?= csrf_hash(); ?>"; 

        const commentSection = document.getElementById('comment-section');
        const commentBtn = document.getElementById('comment-btn');

        commentBtn.addEventListener('click', function handleClick() {
            if (commentSection.style.display === 'none') {
                commentSection.style.display = 'block';
            
            } else {
                commentSection.style.display = 'none';
            }
        });

        $('#comment-form').on('submit', function() {
            var dataJson = {
                [csrfName]:csrfHash,
                comment_text: $('#comment-text').val(),
                commenter: $('#commenter').val(),
                comment_id: $('#comment_id').val(),
                viewkey: $('#viewkey').val(),
            };

            $.ajax ({
                type: 'post',
                url: "<?= base_url(); ?>/images/view_image/<?= $image->viewkey;?>",
                data: dataJson,
                datatype: 'json',
                success: function (data) {
                    csrfName = data.csrfName;
                    csrfHash = data.csrfHash;

                    $('#display-comment').html(data);
                    $('#display-comment').fadeIn(slow);
                }
            });
        });
    });

</script>