<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ImageModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'images';
    protected $primaryKey = 'viewkey';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';  
    protected $useSoftDelete = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'viewkey',
        'uploader',
        'filename',
        'title',
        'tags',
        'album_name',
        'modified_at',
    ];

    // Validation
    protected $validationRules = 'upload';
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

    public function getImage(array $where, string $isArray = '')
    {
        return $this->builder()
            ->where($where)
            ->get()
            ->getRow();
    }

    public function getImagesWhere(array $where)
    {
        return $this->builder()
            ->where($where)
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getAllImages()
    {
        return $this->builder()
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function storeImage(array $data)
    {
        $data = $this->updateModified($data);

        $exists = $this->builder()
            ->where('viewkey', $data['viewkey'])
            ->countAllResults();

        if  ($exists > 0){

            return $this->builder()->where('viewkey', $data['viewkey'])->update($data);
        
        } else {

            return $this->builder()->insert($data);
        }
    }

    public function deleteImage(array $where)
    {
        return $this->builder()
            ->where($where)
            ->delete();
    }

    public function fillImageEntity(string $viewkey)
    {
        $imageData = $this->builder()
            ->where('viewkey', $viewkey)
            ->get()
            ->getRowArray();

        $image = new \App\Entities\Image();

        $image->fill($imageData);
        $image->setDislikeCount($viewkey);
        $image->setLikeCount($viewkey);
        $image->setViewCount($viewkey);
        $image->setFavoriteCount($viewkey);
        $image->setCommentCount($viewkey);
        $image->setRating($viewkey);
        $image->setUserDisliked($viewkey);
        $image->setUserLiked($viewkey);
        $image->setUserViewed($viewkey);
        $image->setUserFavorited($viewkey);
        $image->setUserCommented($viewkey);
        $image->setUserSubscribed($imageData['uploader']);
        $image->setIsUploader($viewkey);
        $image->setAlbumName($viewkey, $imageData['uploader']);

        return $image;
    }

    public function getEntireGallery()
    {
        $images = $this->builder()
            ->orderBy('modified_at', 'RANDOM')
            ->get()
            ->getResultArray();

        foreach ($images as $image) {

            $gallery[$image['id']] = $this->fillImageEntity($image['viewkey']);
        }

        return $gallery;
    }

    public function getGallery(array $where, string $fieldname = 'modified_at', string $order = 'DESC')
    {
        $gallery = [];

        $images = $this->builder()
            ->where($where)
            ->orderBy($fieldname, $order)
            ->get()
            ->getResult();

        if (! empty($images)) {

            foreach ($images as $image) {

                $gallery[$image->id] = $this->fillImageEntity($image->viewkey);
            }

        }
        
        return $gallery;
        
    }

    public function getThumbnails(string $uploader)
    {
        $thumbnailList = [];

        $images = $this->builder()
            
            ->where('uploader', $uploader)
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();

        if (! empty($images)) {

            foreach ($images as $image) {
                
                $thumbnailList[$image->id] = [
                    'viewkey'   => $image->viewkey,
                    'filename'  => $image->filename,
                    'title'     => $image->title,
                ];
            }
        }

        return $thumbnailList;
    }

     public function getUserHistory(string $user)
    {
        $viewedImages = [];

        $imageList = $this->builder('actions')
            ->where(['username' => $user, 'action' => 2])
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();

        if (! empty($imageList)) {

            foreach ($imageList as $viewed) {

                $viewedImages[$viewed->id] = $this->fillImageEntity($viewed->viewkey);
            }

            return $viewedImages;
        
        } else {

            return NULL;
        }
    }

    public function getUserFavorites(string $user)
    {
        $favoriteImages = [];

        $imageList = $this->builder('actions')
            ->where(['username' => $user, 'action' => 3])
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();

        if (! empty($imageList)) {

            foreach ($imageList as $favorite) {

                $favoriteImages[$favorite->id] = $this->fillImageEntity($favorite->viewkey);
            }

            return $favoriteImages;
        
        } else {

            return NULL;
        }
    }
}    