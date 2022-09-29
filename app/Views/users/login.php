<?php if (isset($errors)) : ?>
    <div class='notify-error'>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error); ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

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

<div class='form-container'>

    <?= form_open(route_to('login'),['autocomplete' => FALSE]); ?>

        <div class='form-header'>
            <h2>Login</h2>
        </div>
        
        <div class='form-body'>

            <div class='form-row'>
                <div class='input-container'>
                    <i class='fas fa-user'></i>

                    <?php $attributes = [
                        'type'      => 'text',
                        'name'      => 'username',
                        'class'     => 'input-field',
                        'id'        => 'username',
                        'placeholder'   => 'Username',
                        'required'      => TRUE,
                    ]; ?>
                    <?= form_input($attributes); ?>
                
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class='fas fa-lock'></i>

                    <?php $attributes = [
                        'type'          => 'password',
                        'name'          => 'password',
                        'class'         => 'input-field',
                        'placeholder'   => 'Password',
                        'required'      => TRUE,
                    ]; ?>
                    <?= form_input($attributes); ?>
                  
                </div`>
            </div>
        </div>
                
        <div class='captcha-container'>
            <div class='g-recaptcha' data-sitekey='<?= env('RECAPTCHAV2_sitekey'); ?>'></div>
        </div>

        <div class='form-footer'>

            <?php $submit = [
                    'name'      => 'loginSubmit',
                    'value'     => 'Login',
                    'class'     => 'submit-btn',
            ];?>
            <?= form_submit($submit); ?>
    
        </div>

        <h4 style='text-align: center'>Not a member yet? Register 
            <a href= <?= route_to('register'); ?> title = 'Register'> HERE</a>
        </h4>

     <?= form_close(); ?>
</div>
