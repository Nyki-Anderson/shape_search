<div class='manage-uploads-header'>
    Uploads Overview
</div>

<a href='<?= route_to('new_upload'); ?>'><button class='new-upload-button'><i class="fa-solid fa-plus" title='Upload New Image'></i></button></a>

<table id='manage-uploads' class='manage-uploads'>
    <tr class='upload-header'>
        <th></th>
        <th>Album</th>
        <th>Title</th>
        <th>Tags</th>
        <th>Upload Date</th>
        <th>Modified Date</th>
        <th>Statistics</th>
        <th>Action</th>
    </tr>
    <?php if (! empty($uploads)) {
        foreach ($uploads as $row) { ?>
        <tr>
            <td class='upload-image'>
                <img src= '<?= base_url('/assets/img/uploads/' . $row->filename) ?>', alt=' <?= esc($row->title) ?>' class='upload-thumbnail'>
            </td>

            <td class='upload-album'>
                <div class='album-dropdown'>
                    <div id='viewkey-<?= esc($row->viewkey); ?>' class='upload-album-name'>
                        <span><?= esc($row->album_name); ?></span>
                    </div>

                    <div class='album-dropbtn' title='Move to Album'>
                        <i class="fa-solid fa-square-caret-down" ></i>
                    </div>

                    <div class='album-dropdown-content'>
                        <div class='checkbox new-album-div'>
                            <label class='album-select new-album-select' for='new-album-<?= esc($row->id); ?>'>

                                <span class='album-title'>
                                    New Album
                                </span>

                                <input type='checkbox' name='album[]'  class='new-album-checkbox' id='new-album-<?= esc($row->id); ?>'/>

                                <span class='checkmark'></span>

                                <input id='txt-<?= esc($row->id); ?>' type='text' name='new_album[]' class='new-album-text'/>

                                <button class='new-album-button' data-viewkey='<?= esc($row->viewkey); ?>' data-id='<?= esc($row->id); ?>'>Create</button>
                            </label>
                        </div>

                        <div class='album-list checkbox'>
                            <?php if (! empty($albums)) {
                                $i = 0;
                                foreach ($albums as $album) { ?>
                                    <label for='album-checkbox-<?= esc($album->album_id); ?>' class='album-select'>

                                        <span class='album-title'>
                                            <?= esc($album->album_name); ?>
                                        </span>

                                        <i class="fa-solid fa-xmark"></i>

                                        <input type='checkbox' name='album[]' value='<?= esc($album->album_name); ?>' class='album-checkbox' id='album-checkbox-<?= esc($album->album_id); ?>'/>

                                        <span class='checkmark'></span>
                                    </label>
                            <?php $i++; }} ?>
                        </div>
                    </div>
                </div>
            </td>

            <td>
                <?= esc($row->title); ?>
            </td>

            <td>
                <?php $tags = preg_replace('/-/', ' ', explode(',', $row->tags));
                foreach ($tags as $tag) {
                    echo $tag . ', ';
                } ?>
            </td>

            <td>
                <?= esc($row->createdAt); ?>
            </td>

            <td>
                <?= esc($row->modifiedAt); ?>
            </td>

            <td class='upload-statistics'>
                <div title='Views'><i class="fa-solid fa-eye"></i> <?= esc($row->viewCount); ?></div>
                <div title='Likes'><i class="fa-solid fa-thumbs-up"></i> <?= esc($row->dislikeCount); ?></div>
                <div title='dislikes'><i class="fa-solid fa-thumbs-down"></i> <?= esc($row->likeCount); ?></div>
            </td>

            <td class='upload-actions'>
                <a href='<?= route_to('edit_upload', $row->viewkey) ?>' data-id='<?= esc($row->viewkey); ?>' title='Edit'><i class='fas fa-edit'></i></a>

                <a href='<?= route_to('delete_upload', $row->viewkey) ?>' data-id='<?= esc($row->viewkey); ?>' title='Delete'><i class='fas fa-trash-alt'></i></a>
            </td>
        </tr>
        <?php }} ?>
</table>

