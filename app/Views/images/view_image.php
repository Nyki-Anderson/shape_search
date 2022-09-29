<div class="view-image">

    <div class="view-image-object">

        <div class='view-image-title'>
            <?= esc($image->title);?>
        </div>

        <img src="<?= esc(base_url('/assets/img/uploads/' . $image->filename)); ?>" alt="<?= esc($image->title) ?>">

        <div class='view-image-content'>

            <div class='view-image-icons'>

                <div class='view-image-left-info'>

                    <div class='view-image-info-l'>
                        <i class='fa-solid fa-eye'></i>
                        &nbsp;
                        <span class='viewCount'>
                            <?= esc($image->viewCount);?>
                        </span>
                        &nbsp;&nbsp;
                    </div>

                    <div class='view-image-info-l'>
                        <i class='fa-solid fa-thumbs-up'></i>
                        &nbsp;
                        <span>
                            <?= esc($image->rating);?>
                        </span>
                        &nbsp;&nbsp;
                    </div>

                    <div class='view-image-info-l'>
                        <i class="fa-solid fa-calendar"></i>
                        &nbsp;
                        <span>
                            <?= esc($image->modifiedAt); ?>
                        </span>
                        &nbsp;&nbsp;
                    </div>
                </div>

                <div class='view-image-right-info'>
                            
                    <div class='view-image-info-r'>
                        <i <?php if ($image->userLiked): ?>
                            class='fa fa-thumbs-up like-button'  
                        <?php else: ?>
                            class='fa fa-thumbs-o-up like-button' 
                        <?php endif ?>
                            data-viewkey="<?= esc($image->viewkey); ?>"></i>
                        <span class='likeCount'><?= esc($image->likeCount); ?></span>
                    </div>
                    
                    <div class='view-image-info-r'>
                        <i <?php if ($image->userDisliked): ?>
                            class='fa fa-thumbs-down dislike-button' 
                        <?php else: ?>
                            class='fa fa-thumbs-o-down dislike-button' 
                        <?php endif ?>
                            data-viewkey="<?= esc($image->viewkey); ?>"></i>
                        <span class='dislikeCount'><?= esc($image->dislikeCount); ?></span>
                    </div>

                    <div class='view-image-info-r'>
                        <i <?php if ($image->userFavorited): ?>
                            class='fa-solid fa-heart favorite-button' 
                        <?php else: ?>
                            class='fa-regular fa-heart favorite-button' 
                        <?php endif ?>
                            data-viewkey="<?= esc($image->viewkey) ?>"></i>
                        <span class='favoriteCount'><?= esc($image->favoriteCount); ?></span>
                    </div>

                    <div class='view-image-info-r'>
                        <?php if ($image->userCommented): ?>
                            <i class="fa-solid fa-comments" id='comment-btn'></i>
                        <?php else: ?>
                            <i class="fa-regular fa-comment comments-button" id='comment-btn'></i>
                        <?php endif ?>
                        <span class='commentCount'><?= esc($image->commentCount); ?></span>
                    </div>
            
                    <div class='view-image-info-r' id='flag-button'>
                        <i class="fa-regular fa-flag flag-button"></i>

                        <span class='flags'><?//= esc($flags); ?></span>
                    </div>
                </div>
            </div>

            <div class='view-image-uploader-info'>
                <div class='view-image-uploaded-by'>
                    <a href='<?= route_to('member_profile', $image->uploader); ?>'>
                    <i class="fa-solid fa-circle-user fa-2x"></i><?= ($image->isUploader === FALSE) ? esc($image->uploader) : esc('You');?></a>
                </div>

                <button class='subscribe-button' data-user='<?= esc($image->uploader); ?>'> 
                    <?php if (! $image->userSubscribed): ?>  
                        <i class="fa-solid fa-rss"></i> Subscribe
                    <?php else: ?>
                        <i class="fa-solid fa-user-check"></i>Subscribed
                    <?php endif ?>
                </button>
            </div>

            <div class='view-image-tags-container'>
                <h3>Tags:</h3>
                <?php 
                    $tags = preg_replace('/-/', ' ', explode(',', $image->tags));
                    if (!empty($tags)) {
                        foreach ($tags as $tag) { ?>
                            <div class='view-image-tags'>
                                <?= esc($tag); ?>
                            </div> <?php
                        }
                    }                      
                ?>
                <div class='suggest'>
                    <span id='suggest-button'><i class="fa-solid fa-plus"></i></span>
                    <span id='suggest-text'>Suggest</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='comment-container' id='comment-section'>

    <div id='comment-title'>
        Comments
    </div>

    <div class='comment-form'>

        <?php $attributes = [
            'action'    => 'javascript:void(0)',
            'name'      => 'comment_form',
            'class'     => 'comment-form',
            'id'        => 'comment-form',
        ]; ?>
        <?= form_open('', $attributes);?>

            <?php $data = [
                'name'      => 'comment_id',
                'id'        => 'comment-id',
                'value'     => 0,
            ]; ?>
            <?= form_hidden($data); ?>

            <?php $data = [
                'name'      => 'viewkey',
                'id'        => 'viewkey',
                'value'     => $image->viewkey,
            ]; ?>
            <?= form_hidden($data); ?>

            <?php $data = [
                'name'      => 'commenter',
                'id'        => 'commenter',
                'value'     => session()->get('username'),
            ]; ?>
            <?= form_hidden($data); ?>

            <div class='form-row'>

                <?php $data = [
                    'name'          => 'comment_text',
                    'class'         => 'comment-text',
                    'id'            => 'comment-text',
                    'rows'          => '2',
                    'placeholder'   => 'Join the conversation!',
                ]; ?>
                <?= form_textarea($data); ?>

                <?php $data = [
                    'name'      => 'comment_submit',
                    'class'     => 'comment-submit',
                    'id'        => 'comment-submit',
                ]; ?>
                <?= form_submit($data, 'COMMENT'); ?>
            </div>
        <?= form_close(); ?>
    </div>

    <?php if (! empty($comments)) {
        foreach ($comments as $comment){ ?>

            <div class='comment-object'>
                <div class='comment-header'>
                    <div class='comment-avatar'>
                        <img src='<?= base_url("/assets/img/profile/" . $comment->avatar); ?>'>
                    </div>
                    <div class='comment-author'>
                        <?= esc($comment->commenter); ?>
                    </div>
                    <div class='comment-modified'>
                        <?= esc($comment->comment_modified); ?>
                    </div>
                </div>
                <div class='comment-body'>
                    <?= esc($comment->comment_text); ?>
                </div>
            </div>

    <?php }} else { ?>
        There are no comments yet.
    <?php } ?>
</div>