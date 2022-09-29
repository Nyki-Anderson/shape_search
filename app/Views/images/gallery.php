<div class = 'main-gallery'>

<?php
if (! empty($gallery)) {
    
    foreach ($gallery as $row) {
?>    
    <div class = 'image-object'>
                <a href='<?= route_to('view_image', esc($row->viewkey)); ?>' title='<?= esc($row->title);?>'>
                <img src='<?= base_url('/assets/img/uploads/' . $row->filename); ?>' alt='<?= esc($row->title);?>'></a>

                <div class='image-info'>

                    <div class='image-title'>
                        <?= esc($row->title);?>
                    </div>

                    <div class='uploaded-by'>
                        <a href='<?= route_to('member_profile', $row->uploader); ?>' title="<?= $row->uploader; ?>'s Profile">
                            <i class='fas fa-user-alt'></i>&nbsp;&nbsp; <?= esc($row->uploader);?>
                        </a>
                    </div>

                    <div class='bottom-row'>
                        <div class='view-count'>
                            <i class='fa-solid fa-eye'></i>&nbsp;&nbsp; <?= esc($row->viewCount) ?>
                        </div>

                        <div class='like-percent' style='float:right'>
                            <?= esc($row->rating);?>&nbsp;&nbsp;
                            <i class='fa-solid fa-thumbs-up'></i>
                        </div>
                    </div>
                </div>
            </div>

        <?php }} else { ?>
            <div class = 'notify-warning'>
                No image(s) found...
            </div> 
        <?php } ?>
    </div>
    