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

    <?php if (isset($uploadFilename)) { ?>

        <?= form_open_multipart(route_to('edit_upload', $viewkey), ['autocomplete' => FALSE]); ?>

    <?php } else { ?>

        <?= form_open_multipart(route_to('new_upload'), ['autocomplete' => FALSE]); ?>

    <?php } ?>

        <div class='form-header'>
            <h2><?= esc($title); ?></h2>
        </div>
        
        <div class='form-body'>

            <?php if (isset($uploadFilename)) { ?>
                <div class='form-preview'>

                    <img src='<?= base_url('/assets/img/uploads/' . $uploadFilename);?>' style='margin-top: 12px;' id='upload-preview'>
                    
                </div>

            <?php } else { ?>
                <div class='form-preview'>

                    <img src='<?= base_url('/assets/img/uploads/default-image.jpg');?>' style='margin-top: 12px;' id='upload-preview'>

                </div>
            <?php } ?>
           
            <div class='form-row'>
                <div class='input-container'>
                    <i class='fa-solid fa-pen-to-square'></i>

                    <?php $data = [
                        'type'          => 'text',
                        'name'          => 'title',
                        'class'         => 'input-field',
                        'id'            => 'title',
                        'placeholder'   => 'Type image title here.',
                        'size'          => '50px',
                        'value'         => !empty($uploadTitle)?esc($uploadTitle):'',
                    ];?> 

                    <?= form_input($data); ?>
    
                </div>
            </div>
            
            <div class='form-row'>
                <div class='input-container'>
                    <i class='fa-solid fa-tags'></i>
                    
                    <?php $data = [
                            'type'          => 'textarea',
                            'name'          => 'tags',
                            'class'         => 'input-field',
                            'id'            => 'tags',
                            'placeholder'   => 'Enter at least 1 tag describing the image separated by a space " " or a ",". Multiple words should be delimited by a hyphen "-".',
                            'value'         => !empty($uploadTags)?esc($uploadTags):'',
                    ]; ?>

                    <?= form_input($data, 'required'); ?>
                    
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class="fa-solid fa-folder"></i>

                    <select name='album_name' class='input-field' id='album'>

                        <option value=''>Select an Album</option>
                        <?php if (! empty($albums)) {
                            foreach ($albums as $album) {
                                echo '<option value="' . $album->$album_name . '">' . $album->$album_name . '</option>';
                        }} ?>

                    </select>
                </div>
            </div>
            
            <div class='form-row'>

                <?php $data = [
                        'type'      => 'file',
                        'name'      => 'image',
                        'class'     => 'input-field',
                        'id'        => 'image',
                        'onchange'  => 'onFileUpload(this);',
                        'accept'    => 'image/*',
                ]; ?>

                <?= form_upload($data, 'required'); ?>
                
            </div>
        </div>

        <div class='form-footer'>

            <?php $data = [
                    'type'  => 'submit',
                    'name'  => 'uploadSubmit',
                    'class' => 'submit-btn',
            ]; ?>

            <?= form_button($data, 'Upload'); ?>
           
        </div>
    <?= form_close(); ?>
</div>
