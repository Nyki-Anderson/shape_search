<div class='tabs'>
    <input type='radio' id='tab1' name='tab-control' checked>
    <label for='tab1'><i class="fa-solid fa-image"></i> Images</label>

    <input type='radio' id='tab2' name='tab-control'>
    <label for='tab2'><i class="fa-solid fa-folder"></i> Albums</label>

    <input type='radio' id='tab3' name='tab-control'>
    <label for='tab3'><i class="fa-solid fa-user"></i> Profiles</label>

    <div class='tab content1'>
        <div class='main-gallery'>
            <?php if (! empty($imageHistory)) {
                
                foreach ($imageHistory as $row) {
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
                    No image history yet...
                </div> 
            <?php } ?>
        </div>
    </div>

    <div class='tab content2'>

    </div>

    <div class='tab content3'>
        <div class='user-gallery'>
            <?php if (! empty($profileHistory)) {
                $i = 0;
                foreach($profileHistory as $row) {
                    $i++;
            ?>
                <div class='user-object'>
                    <div class='user-profile-image'>
                        <a href='<?= route_to('member_profile', $row->username); ?>' title='<?= esc($row->username); ?>'>
                        <img src='<?= base_url('/assets/img/profile/' . $row->profile_image); ?>' alt='<?= esc($row->username); ?>'s Profile Image>
                    </div>
                    <div class='user-username'>
                        <?= esc($row->username); ?>
                    </div>
                    </a> 
                    <div class='user-info'>
                        <div class='user-dropdown'>
                                <button class='user-dropbtn'>
                                    <i class="fa-solid fa-user-group"></i>&nbsp;&nbsp; Subscribers &nbsp;&nbsp;<?= esc($row->subscriberCount); ?>
                                </button>
                                <div class='user-dropcontent'>
                                    <?php if(! empty($row->subscribers)) {
                                        foreach($row->subscribers as $profileThumbnail) { ?>
                                            <a href='<?= route_to('member_profile', $profileThumbnail['subscriber']); ?>'>
                                            <div class='thumbnail'>
                                                <img src='<?= base_url('/assets/img/profile/' . $profileThumbnail['profile_image']); ?>'>
                                            </div>
                                            <?= esc($profileThumbnail['subscriber']); ?></a>
                                        
                                    <?php }}?>
                                </div>
                        </div>
                        <div class='user-dropdown'>
                            <button class='user-dropbtn'>
                                <i class="fa-solid fa-image"></i>&nbsp;&nbsp; Uploads &nbsp;&nbsp;<?= esc($row->uploadCount); ?>
                            </button>
                            <div class='user-dropcontent'>
                                <?php if(! empty($row->uploads)) {
                                    foreach($row->uploads as $uploadsThumbnail) { ?>
                                        <a href='<?= route_to('view_image', $uploadsThumbnail['viewkey']); ?>'>
                                        <div class='thumbnail'>
                                            <img src='<?= base_url('/assets/img/uploads/' . $uploadsThumbnail['filename']); ?>'>
                                            <?= esc($uploadsThumbnail['title']); ?>
                                        </div>
                                        </a>
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }} else {?>
                <div class = 'notify-warning'>
                    User does not have any subscribers yet.
                </div> 
            <?php } ?>
        </div>
    </div>
</div>