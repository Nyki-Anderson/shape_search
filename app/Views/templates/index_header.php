<!DOCTYPE html>

<html lang="en">
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
  ] ?>
      <?= link_tag($link); ?>

      <!-- Stylesheet file -->
      <?php $link = [
    'href'  => 'assets/css/light-theme.css?v=24',
    'rel'   => 'stylesheet',
    'type'  => 'text/css',
  ]; ?>
      <?= link_tag($link); ?>

      <!-- Font awesome icons library -->
      <?php $script = [
    'src'           => 'https://kit.fontawesome.com/7d7fc3eb87.js?v=24',
    'crossorigin'   => 'anonymous',
  ]; ?>
      <?= script_tag($script); ?>

      <!-- J-Query Libraries -->
      <?php $script = [
    'src'           => 'https://code.jquery.com/jquery-3.6.0.min.js?version=51',
    'integrity'     => 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=',
    'crossorigin'   => 'anonymous',
    'type'          => 'text/javascript',
  ]; ?>
      <?= script_tag($script); ?>

      <!-- AJAX library -->
      <?php $script = [
    'src'       => 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
    'type'      => 'text/javascript',
    'charset'   => 'utf-8',
  ]; ?>

      <!-- Google Recaptcha API -->
      <?php $script = [
    'src'   => 'https://www.google.com/recaptcha/api.js',
  ]; ?>
      <?= script_tag($script); ?>

      <title><?= esc($title); ?></title>
    </head>

    <body>
      <article>
        <nav class='navbar'>
          <button class='logobtn'>
            <a href="<?= route_to('home') ?>" title='Home'><i class='fas fa-shapes'></i>
              <span style='font-weight:bold; font-size:50px'>S</span>hape <span
                style='font-weight:bold; font-size:50px'>S</span>earch</a>
          </button>

          <div class='dropdown'>
            <button class='dropbtn'>
              <i class="fa-solid fa-bars" title='User Actions'></i>
            </button>

            <div class='dropdown-content' style='min-width:50px;'>

              <a href="<?= route_to('register') ?>" title='Register'>Register <i class='fas fa-user-circle'
                  style='color:black'></i></a>

              <a href="<?= route_to('login') ?>" title='Login'>Login <i class='fas fa-sign-in-alt'
                  style='color:black'></i> </a>
            </div>
          </div>
        </nav>

        <div class='content'>

          <!-- Error, Success, Warning, Info Messages -->
          <div class='notification-bar'>
            <?php if (session()->getFlashdata('error') != NULL) : ?>

            <div class='notify-error'>
              <?= session()->getFlashdata('error'); ?>
            </div>

            <?php endif;

        if (session()->getFlashdata('success') != NULL) : ?>

            <div class='notify-success'>
              <?= session()->getFlashdata('success'); ?>
            </div>

            <?php endif;

        if (session()->getFlashdata('warning') != NULL) : ?>

            <div class='notify-warning'>
              <?= session()->getFlashdata('warning'); ?>
            </div>

            <?php endif;

        if (session()->getFlashdata('info') != NULL) : ?>

            <div class='notify-info'>
              <?= session()->getFlashdata('info'); ?>
            </div>

            <?php endif; ?>
          </div>