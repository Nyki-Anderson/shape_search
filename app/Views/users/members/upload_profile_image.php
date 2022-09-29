<?php if (isset($errors)) : ?>
    <div class='notify-error'>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error); ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<div class='form-container'>

    <?= form_open_multipart(route_to('profile_image'), ['autocomplete' => FALSE, 'id' => 'upload-image-form']); ?>
        <div class='form-header'>
            <h2><?= esc($title); ?></h2>
        </div>
        
        <div class='form-body'>

            <div class='form-preview'>

                <img src='<?= base_url('/assets/img/profile/' . session()->get('profile_image'));?>' style='margin-top: 12px;' id='upload-preview'>
                
            </div>
            
            <div class='form-row'>

                <?php $data = [
                        'type'      => 'file',
                        'name'      => 'image',
                        'class'     => 'input-field',
                        'id'        => 'image-upload',
                        'multiple'  => TRUE,
                        'onchange'  => 'onFileUpload(this);',
                        'accept'    => 'image/*',
                ]; ?>

                <?= form_upload($data); ?>
                
            </div>
        </div>

        <div class='form-footer'>

            <?php $data = [
                    'type'  => 'submit',
                    'name'  => 'uploadSubmit',
                    'class' => 'submit-btn upload-btn',
            ]; ?>

            <?= form_button($data, 'Upload'); ?>
           
        </div>
    <?= form_close(); ?>
</div>