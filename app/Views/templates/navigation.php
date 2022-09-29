<div class='primary-nav'>
    <div class='dropdown' style='float:left;'>
        <button class='dropbtn'>
            <a href='<?= route_to('member_dashboard'); ?>'>Dashboard <i class='fas fa-caret-down'></i></a>
        </button>

        <div class='dropdown-content' style='left:0;'>
            <a href='<?= route_to('feed', session()->get('username')); ?>'>Feed</a>
            <a href='#'>Subscriptions </a>
            <a href='<?= route_to('history'); ?>'>History</a>
            <a href='<?= route_to('favorites'); ?>'>Favorites</a>
            <a href='#'>Recommendations</a>
            <a href='#'>Taste Profile</a>
        </div>
    </div>

    <div class='dropdown' style='float:left;'>
        <button class='dropbtn'>
            <a href='<?= route_to('gallery'); ?>'>Gallery <i class='fas fa-caret-down'></i></a>
        </button>
            
        <div class='dropdown-content' style='left:0;'>
            <a href='#'>Newest Images</a>
            <a href='#'>Hottest Images</a>
            <a href='#'>Most Viewed Images</a>   
        </div>
    </div>  

    <div class='dropdown' style='float:left;'>
        <button class='dropbtn'>
            <a href=''>Categories <i class='fas fa-caret-down'></i></a>
        </button>
        
        <div class='dropdown-content' style='left:0;'>
            <a href='#'>Circles</a>
            <a href='#'>Hearts</a>
            <a href='#'>Lines</a>
            <a href='#'>Ovals</a>
            <a href='#'>Rectangles</a>
            <a href='#'>Squares</a>
            <a href='#'>Stars</a>
            <a href='#'>Triangles</a>
        </div>
    </div>

    <div class='dropdown' style='float:left;'>
        <button class='dropbtn'>
            <a href='#'>Community <i class='fas fa-caret-down'></i></a>
        </button>
            
        <div class='dropdown-content' style='left:0;'>
            <a href='#'>Newest Profiles</a>
            <a href='#'>Hottest Profiles</a>
            <a href='#'>Most Viewed Profiles</a>
        </div>
    </div>
</div>

<div class = 'content'>

    <!-- Error, Success, Warning, Info Messages -->
    <div class='notifcation-bar'>
        <?php if (session()->getFlashdata('error') != NULL) : ?>

            <div class='notify-error'>
                <?= session()->getFlashdata('error'); ?>
            </div>

        <?php endif; 
        
        if (session()->getFlashdata('success') != NULL) : ?>

            <div class = 'notify-success'> 
                <?= session()->getFlashdata('success'); ?>
            </div>
        
        <?php endif;

        if (session()->getFlashdata('warning') != NULL) : ?>

            <div class = 'notify-warning'> 
                <?= session()->getFlashdata('warning'); ?>
            </div>
        
        <?php endif;

        if (session()->getFlashdata('info') != NULL) : ?>

            <div class = 'notify-info'> 
                <?= session()->getFlashdata('info'); ?>
            </div>
        
        <?php endif; ?>
    </div>
