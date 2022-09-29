<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\Comments::class;
    protected $useSoftDelete = false;
    protected $allowedFields = [
        'comment_id',
        'comment_text',
        'comment_created',
        'comment_modified',
        'parent_id',
        'viewkey',
        'commenter',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $modifiedField = 'modified_at';
    protected $deletedField = 'deleted';

    public function __construct ()
    {
        parent::__construct();
    }

    public function updateModified(array $data)
    {
       $modified = Time::now('America/New_York', 'en_US');

       if ($data['comment_modified'] === NULL) {

            $data['comment_modified'] = $modified;
        
            return $data;
        }
    }

    public function fillCommentsEntity(array $data)
    {
        $comments = new \App\Entities\Comment($data);

        $comments->setAvatar($data->commenter);

        return $comments;
    }

    public function addComment(array $data)
    {
        $data = $this->updateModified($data);

        return ($this->builder()->insert($data));
    }

    public function getComments(string $viewkey)
    {
        $query = $this->builder()
            ->where('viewkey', $viewkey);

        if ($query->countAllResults() > 0) {

            $data = $query->getResult();

            return $this->fillCommentsEntity($data);
        
        } else {

            return NULL;
        }
    }
}