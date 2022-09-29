<div class='profile-container'>
    <!-- Profile Header -->
    <div class='profile-header'>
        <div class='profile-img'>
            <img src="<?= base_url('/assets/img/profile/' . $profile->profile_image); ?>" alt='<?= $profile->username . "'s Profile Image"; ?>'>
        </div>

        <?php if ($editProfile): ?>
            <div class='profile-image-edit'>
                <a href="<?= route_to('profile_image'); ?>"><i class="fa-solid fa-file-image" title='Edit Profile Image'></i></a>
            </div>
        <?php endif ?>

        <div class='profile-username'>
            <a href='<?= route_to('member_profile', $profile->username); ?>' title="<?= $profile->username; ?>'s Profile"><?= esc($profile->username); ?></a>
        </div>

        <div class='profile-cover-image'>
            <img src="<?= base_url('/assets/img/content/cover-image.jpg'); ?>" alt='Wide Geometric Image in Blue and Gray'>
        </div>

        <?php if ($editProfile): ?>
            <div class='profile-edit'>
                <a href="<?= route_to('edit_profile'); ?>"><i class="fa-solid fa-user-pen" title='Edit Profile'></i></a>
            </div>
        <?php endif ?>

        <?php if (! $editProfile): ?>
            <button class='subscribe-button profile-subscribe' data-user='<?= esc($profile->username); ?>'> 
                <?php if (! $profile->userSubscribed): ?>  
                    <i class="fa-solid fa-rss"></i> Subscribe
                <?php else: ?>
                    <i class="fa-solid fa-user-check"></i>Subscribed
                <?php endif ?>
            </button>
        <?php endif ?>
    </div>

    <div class='profile-column-container'>
        <div class='profile-column'>
            <!-- Profile Biography -->
            <div class='profile-section-title'>
                <i class="fa-solid fa-dna"></i> Biography
            </div>
            <div class='profile-biography'>
                <?php if (! empty($profile->about_me)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>About <?= esc($profile->username); ?>:</span>
                            <span> <?= esc($profile->about_me); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->age)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Birthday:</span>
                            <span><?= esc($profile->age); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->gender)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Gender:</span>
                            <span>
                                <?php if ($profile->gender == 'f'): ?>
                                    Female <i class="fa-solid fa-venus"></i>
                                <?php endif ?>
                                <?php if ($profile->gender == 'm'): ?>
                                    Male <i class="fa-solid fa-mars"></i>
                                <?php endif ?>
                            </span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->occupation)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Occupation:</span>
                            <span><?= esc($profile->occupation); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->hometown)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Hometown:</span>
                            <span><?= esc($profile->hometown); ?>, </span>
                            <span><?= esc($profile->country); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->fav_shape)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Favorite Shape:</span>
                            <span><?= esc($profile->fav_shape); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->fav_color)): ?> 
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Favorite Color:</span>
                            <span><?= esc($profile->fav_color); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (! empty($profile->last_login)): ?>
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Last Login:</span>
                            <span><?= esc($profile->last_login); ?></span>
                        </div>
                    </div>
                <?php endif ?>
                
                    <div class='profile-info-row'>
                        <div class='profile-content'>
                            <span style='font-weight: bolder;'>Profile Views:</span>
                            <span id='profileCount'><?= esc($profile->profileViews); ?></span>
                        </div>
                    </div>
              
            </div>
        <!-- Profile Image Gallery -->   
            <div class='profile-section-title'>
                <i class="fa-solid fa-image"></i> <?= esc($profile->username); ?>'s Images
            </div>
            <div class='profile-gallery'>
                <?php if (! empty($profileUploads)) {
                    $i = 0;
                    foreach ($profileUploads as $row) {
                        $i++;
                ?>
                    <div class ='profile-image-object'>
                        <div class='profile-images'>
                            <a href='<?= route_to('view_image', $row->viewkey); ?>' title='<?= esc($row->title);?>'>
                            <img src='<?= base_url('/assets/img/uploads/' . $row->filename); ?>' alt='<?= esc($row->title);?>'></a>
                        </div>
                        <div class='image-info'>

                            <div class='image-title'>
                                <?= esc($row->title);?>
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
                    </div>
                <?php }} else { ?>
                    <div class = 'notify-warning'>
                        User has not uploaded any images yet.
                    </div> 
                <?php } ?>
            </div>
        </div>
        <!-- Profile Subscribers -->
        <div class='profile-column'>
            <div class='profile-section-title'>
                <i class="fa-solid fa-user-group"></i> Subscribers
            </div>

            <div class='subscriber-list'>

                <?php if (! empty($profileSubscribers)) {
                    $i = 0;
                    foreach($profileSubscribers as $subscriber) {
                        $i++;
                ?>
                    <div class='subscriber-object'>
                        <div class='subscriber-profile-image'>
                            <a href='<?= route_to('member_profile', $subscriber->username); ?>' title='<?= esc($subscriber->username); ?>'>
                            <img src='<?= base_url('/assets/img/profile/' . $subscriber->profile_image); ?>' alt='<?= esc($subscriber->username); ?>'s Profile Image>
                        </div>
                        <div class='subscriber-username'>
                            <?= esc($subscriber->username); ?>
                        </div>
                        </a> 
                        <div class='subscriber-info'>
                            <div class='subscriber-dropdown'>
                                    <button class='subscriber-dropbtn'>
                                        <i class="fa-solid fa-user-group"></i>&nbsp;&nbsp; Subscribers &nbsp;&nbsp;<?= esc($subscriber->subscriberCount); ?>
                                    </button>
                                    <div class='subscriber-dropcontent'>
                                        <?php if(! empty($subscriber->subscribers)) {
                                            foreach($subscriber->subscribers as $profileThumbnail) { ?>
                                                <a href='<?= route_to('member_profile', $profileThumbnail['subscriber']); ?>'>
                                                <div class='thumbnail'>
                                                    <img src='<?= base_url('/assets/img/profile/' . $profileThumbnail['profile_image']); ?>'>
                                                </div>
                                                <?= esc($profileThumbnail['subscriber']); ?></a>
                                            
                                        <?php }}?>
                                    </div>
                            </div>
                            <div class='subscriber-dropdown'>
                                <button class='subscriber-dropbtn'>
                                    <i class="fa-solid fa-image"></i>&nbsp;&nbsp; Uploads &nbsp;&nbsp;<?= esc($subscriber->uploadCount); ?>
                                </button>
                                <div class='subscriber-dropcontent'>
                                    <?php if(! empty($subscriber->uploads)) {
                                        foreach($subscriber->uploads as $uploadsThumbnail) { ?>
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
        <!-- Profile Subscriptions List -->
            <div class='profile-section-title'>
                <i class="fa-solid fa-rss"></i> Subscriptions
            </div>
            <div class='subscriber-list'>
                 <?php if (! empty($profileSubscriptions)) {
                    $i = 0;
                    foreach($profileSubscriptions as $subscriber) {
                        $i++;
                ?>
                    <div class='subscriber-object'>
                        <div class='subscriber-profile-image'>
                            <a href='<?= route_to('member_profile', $subscriber->username); ?>' title='<?= esc($subscriber->username); ?>'>
                            <img src='<?= base_url('/assets/img/profile/' . $subscriber->profile_image); ?>' alt='<?= esc($subscriber->username); ?>'s Profile Image>
                        </div>
                        <div class='subscriber-username'>
                            <?= esc($subscriber->username); ?>
                        </div>
                        </a> 
                        <div class='subscriber-info'>
                            <div class='subscriber-dropdown'>
                                    <button class='subscriber-dropbtn'>
                                        <i class="fa-solid fa-user-group"></i>&nbsp;&nbsp; Subscribers &nbsp;&nbsp;<?= esc($subscriber->subscriberCount); ?>
                                    </button>
                                    <div class='subscriber-dropcontent'>
                                        <?php if(! empty($subscriber->subscribers)) {
                                            foreach($subscriber->subscribers as $profileThumbnail) { ?>
                                                <a href='<?= route_to('member_profile', $profileThumbnail['subscriber']); ?>'>
                                                <div class='thumbnail'>
                                                    <img src='<?= base_url('/assets/img/profile/' . $profileThumbnail['profile_image']); ?>'>
                                                </div>
                                                <?= esc($profileThumbnail['subscriber']); ?></a>
                                            
                                        <?php }}?>
                                    </div>
                            </div>
                            <div class='subscriber-dropdown'>
                                <button class='subscriber-dropbtn'>
                                    <i class="fa-solid fa-image"></i>&nbsp;&nbsp; Uploads &nbsp;&nbsp;<?= esc($subscriber->uploadCount); ?>
                                </button>
                                <div class='subscriber-dropcontent'>
                                    <?php if(! empty($subscriber->uploads)) {
                                        foreach($subscriber->uploads as $uploadsThumbnail) { ?>
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
                        User is not subscribed to anyone yet.
                    </div> 
                <?php } ?>
            </div>
        </div>
    </div>
</div>


