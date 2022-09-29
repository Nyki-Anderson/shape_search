<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
        <meta name='description' content='Image search project with user driven recommendations and feedback.'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta name='author' content='AgBRAT'>

        <!-- Favicon file -->
        <?php $link = [
            'href'  => 'favicon.ico',
            'rel'   => 'shortcut icon',
            'type'  => 'image/x-icon'
        ]?>
        <?= link_tag($link); ?>

        <!-- Stylesheet file -->
        <?php $link = [
            'href'  => 'assets/css/light-theme.css?v=24',
            'rel'   => 'stylesheet',
            'type'  => 'text/css',
        ];?>
        <?= link_tag($link); ?>

        <!-- Font awesome icons library -->
        <?php $script = [
            'src'           => 'https://kit.fontawesome.com/7d7fc3eb87.js?v=24',
            'crossorigin'   => 'anonymous',
        ];?>
        <?= script_tag($script); ?>

        <!-- J-Query Libraries -->
        <?php $script = [
            'src'           => 'https://code.jquery.com/jquery-3.6.0.min.js?version=51',
            'integrity'     => 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=',
            'crossorigin'   => 'anonymous',
            'type'          => 'text/javascript',
        ];?>
        <?= script_tag($script); ?>

        <?php $script = [
            'src'           => 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js?version=51',
            'crossorgin'    => 'anonymous',
        ];?>
        <?= script_tag($script); ?>

        <!-- JQuery BlockUI -->
        <?= script_tag('assets/js/jquery-blockUI.js'); ?>

        <!-- Script requiring UUID  -->
        <?php $script = [
            'src'       => 'js-uuid.js',
            'type'      => 'module',
        ]; ?>

        <?= script_tag($script); ?>

        <!-- Datatable JS -->
        <?php $script = [
            'src'       => "https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js",
            'type'      => 'text/javascript',
        ]; ?>
        <?= script_tag($script); ?>

        <title><?= esc($title); ?></title>
</head>
<body>
    <article>
        <nav class='navbar'>
            <div class='left-nav'>
                <button class='logobtn'>
                    <a href="<?= route_to('feed', session()->get('username')); ?>" title='Home'><i class='fas fa-shapes'></i> <span style='font-weight:bold; font-size:40px'>S</span>hape <span style='font-weight:bold; font-size:40px'>S</span>earch</a>
                </button>

                <div class='navbar-title'>
                    <?= esc($title); ?>
                </div>
            </div>

            <div class='right-nav'>

                <div class='search-container' style='float:right'>
                    <input class='no-submit' id='keywords' type='search' placeholder='Search Shapes...' onkeyup='searchFilter();' onkeypress='return (event.keyCode!=13);'>
                </div>

                 <div class='dropdown'>
                    <button class='dropbtn'>
                        <i class='fas fa-bell fa-1x' title='Notifications Center'></i>
                    </button>
                </div>

                <div class='dropdown'>
                    <button class='dropbtn'>
                        <a href='<?= route_to('member_profile', session()->get('username'));?>' title='My Profile'>
                            <img src="<?= esc(base_url('/assets/img/profile/' . session()->get('profile_image'))); ?>" alt='Your Profile Image' class='header-profile-image'>
                        </a>
                    </button>
                    <div class='dropdown-content'>
                        <h3 style='text-align:center'>Welcome: <?= esc(session()->get('username')); ?>!</h3>

                        <a href='<?= route_to('member_dashboard', session()->get('username')); ?>' title='Dashboard'>Dashboard <i class="fa-solid fa-table-columns" style='color:black'></i></a>

                        <a href='<?= route_to('member_profile', session()->get('username'));?>' title='Edit Profile'>My Profile <i class='fas fa-user-edit dropdown-icon' style='color:black'></i></a>

                        <a href='<?= route_to('history'); ?>'>My History <i class="fa-solid fa-clock" style='color:black'></i></i></a>

                        <a href='<?= route_to('favorites'); ?>'>My Favorites <i class='fa-solid fa-heart' style='color:black'></i></a>

                        <a href='<?= route_to('manage_uploads'); ?>'>Manage Uploads <i class='fas fa-upload' style='color:black'></i></a>

                        <a href='#'>Languages <i class='fa-solid fa-earth-americas' style='color:black'></i></a>

                        <a href='#'>Privacy Settings <i class='fa-solid fa-lock' style='color:black'></i></a>

                        <a href='#'>Account Settings <i class="fa-solid fa-gears" style='color:black'></i></a>

                        <a href="<?= route_to('logout'); ?>">Logout <i class='fas fa-sign-out-alt' style='color:black'></i></a>
                    </div>
                </div>
            </div>
        </nav>
    <div class = 'content'>
