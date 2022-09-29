<div class = 'main-gallery'>
    <div class= 'icon-object'>

        <a href='<?= route_to('new_upload') ?>' title='New Upload'><i class='fas fa-upload fa-10x'></i>
        <div class='icon-object-text'>New Upload</div>
        </a>
    </div>

<?php
if (! empty($uploads)) {
    
    foreach ($uploads as $row) {
?> 
    <div class = 'image-object'>

        <img src= '<?= base_url('/assets/img/uploads/' . $row->filename) ?>', alt=' <?= esc($row->title) ?>'>

        <div class='image-info'>
            <div class='image-title'>
                <?php echo esc($row->title);?>
            </div>

            <div class='bottom-row'>
                    <div class='view-count'>
                        <i class='fa-solid fa-eye'></i>
                        &nbsp;&nbsp;
                        <span>
                            <?= esc($row->viewCount);?>
                        </span>
                    </div>

                    <div class='like-percent'>
                        <i class='fa-solid fa-thumbs-up'></i>
                        &nbsp;&nbsp;
                        <span>
                            <?= esc($row->rating);?>
                        </span>
                    </div>

                    <div class='modified'>
                        <i class="fa-solid fa-calendar"></i>
                        &nbsp;
                        <span>
                            <?= esc($row->modified_at); ?>
                        </span>
                    </div>
                </div>
            </div>
    
        <div class='overlay'>
            <div class='actions-left'>

                <a href='<?= route_to('edit_upload', $row->viewkey) ?>' title='Edit'><i class='fas fa-edit'></i></a>
            </div>
            
            <div class='actions-right'>

                <a href='<?= route_to('delete_upload', $row->viewkey) ?>' title='Delete'><i class='fas fa-trash-alt'></i></a> 
            </div>
        </div>
    </div>   
<?php }} ?>
</div> 

