<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class AlbumModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'albums';
    protected $primaryKey = 'owner';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';  
    protected $useSoftDelete = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'owner',
        'album_name',
        'viewkeys',
        'modified_at',
    ];
    // Validation
    protected $validationRules = 'album';
    protected $skipValidation = FALSE;

    public function __construct () 
    {
        parent::__construct(); 

    }

    public function updateModified(array $data)
    {
       $modified = Time::now('America/New_York', 'en_US');

       if ($data['modified_at'] === NULL) {

            $data['modified_at'] = $modified;
        
            return $data;
        }
    }

    public function getUserAlbums(string $owner)
    {
        return $this->builder()
            ->where('owner', $owner)
            ->orderBy('album_name', 'ASC')
            ->get()
            ->getResult();
    }

    public function getAlbum(string $owner, string $album_name)
    {
        return $this->builder()
            ->where(['owner' => $owner, 'album_name' => $album_name])
            ->get()
            ->getRow();
    }

    public function getViewkeys(string $album_name, string $owner)
    {
        $viewkeysArray = $this->builder()
            ->select('viewkeys')
            ->where(['album_name' => $album_name, 'owner' => $owner])
            ->get()
            ->getRowArray();

        return implode(',', $viewkeysArray);
    }

    public function searchAlbum(string $viewkey, string $owner,string $album_name)
    {
        $key = NULL;

        $album = $this->getAlbum($owner, $album_name);

        $viewkeyString = $album->viewkeys;

        $viewkeyArray = explode(',', $viewkeyString);

        $key = array_search($viewkey, $viewkeyArray, TRUE);

        return $key;
    }

    public function removeViewkey(array $data, string $viewkeyString, string $album_name, int $key)
    {
        $viewkeyArray = explode(',', $viewkeyString);

        unset($viewkeyArray[$key]);

        $viewkeyString = implode(',', $viewkeyArray);

        $deleted = $this->builder()
            ->set(['viewkeys' => $viewkeyString, 'modified_at' => $data['modified_at']])
            ->where(['album_name' => $album_name, 'owner' => $data['owner']])
            ->update();
        
        if ($deleted === TRUE) {

            return TRUE;
        
        } else {

            return FALSE;
        }
    
    }

    public function concatenateViewkey(string $viewkey, string $viewkeyString)
    {
       if (empty($viewkeyString)) {

            return $viewkey;

        } else {
            
            return $viewkeyString . ',' . $viewkey;
        }
    }

    public function checkImageAlbum(array $data)
    {
        $data = $this->updateModified($data);

        $response = [];

        $response['csrfName'] = csrf_token();
        $response['csrfHash'] = csrf_hash();

        $albums = $this->getUserAlbums($data['owner']);
        
        // Check if image is in any album already
        if (! empty($albums)) {

            foreach ($albums as $album) {

                $key = $this->searchAlbum($data['viewkey'], $data['owner'], $album->album_name);

                // Image is in an album 
                if (is_int($key)) {

                    // Album exists and image is aready in it
                    if ($album->album_name === $data['album_name']) {

                        $response['album_name'] = $data['album_name'];
                        $response['message'] = 'This upload is already in the album selected.';

                        return json_encode($response);
                    
                    // Image is in album and needs to be removed
                    } else {

                        $viewkeyString = $album->viewkeys;

                        // Remove image from album 
                        if (! $this->removeViewkey($data, $viewkeyString, $album->album_name, $key)) {

                            $response['message'] = 'Image is already in another album and has not been moved. Please try again.';

                            return json_encode($response);
                        }  
                    }
                }
            } 
        } 

        // Album is new and image is not in any other album anymore
        if ((array_search($data['album_name'], array_column($albums, 'album_name'))) === FALSE) {

            $response['message'] = $this->saveImageAlbum($data);

            return json_encode($response);
        
        // Album exists and image is not in any other album
        } else {

            $viewkeyString = $this->getViewkeys($data['album_name'], $data['owner']);

            $viewkeyString = $this->concatenateViewkey($data['viewkey'], $viewkeyString);

            $response['message'] = $this->saveImageAlbum($data, $viewkeyString);

            return json_encode($response);
        }
        
    }

    public function saveImageAlbum (array $data, string $viewkeyString = NULL)
    {
        if ($viewkeyString === NULL) {

            $newAlbum = [
                'owner'         => $data['owner'],
                'album_name'    => $data['album_name'],
                'viewkeys'      => $data['viewkey'],
                'modified_at'   => $data['modified_at'],
            ];

            $this->builder()
                ->insert($newAlbum);

            return 'The new album has been added to your directory and the upload has been successfully moved to this album.';

        } else {

            $this->builder()
                ->set(['viewkeys' => $viewkeyString, 'modified_at' => $data['modified_at']])
                ->where(['album_name' => $data['album_name'], 'owner' => $data['owner']])
                ->update();

            return 'Upload has been successfully moved to the selected album.';
        }
    }
}