<?php foreach($feed as $activity) { ?>

    <div class='feed-object'>
        <div class='feed-row'>
            <div class='feed-header'>
                <?= esc($activity->username);?>
            </div>

            <div class='feed-row'>
                <div class='feed-body'>
                    <?= esc($activity->activity); ?>
                </div>
            </div>

            <div class='feed-row'>
                <div class='feed-footer'>
                </div>
            </div>
        </div>
    </div>
<?php } ?>