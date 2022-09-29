<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validation\User_rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        User_rules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'      => 'CodeIgniter\Validation\Views\list',
        'single'    => 'CodeIgniter\Validation\Views\single',
        'upload'    => 'images/upload',   
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    /**
     *  Image Uploads
     */
    public $image = [
        'image'     => 'uploaded[image]|max_size[image,500000]|max_dims[image,800,800]|mime_in[image,image/png,image/jpeg,image/jpg,image/gif]|ext_in[image,png,jpeg,jpg,gif]|is_image[image]',
    ];

    public $image_errors = [
        'image' => [
            'uploaded'  => 'File was not uploaded.',
            'max_size'  => 'File exceeds max size allowed ({param}).',
            'max_dims'  => 'File exceeds the max allowable dimensions ({param})',
            'mime_in'   => 'File has a mime type that is not allowed. Permitted mime types are image/png, image/jpeg, image/jpg, and image/gif.',
            'ext_in'    => 'File has an invalid extension. Permitted extensions are .png, .jpg, .jpeg, and .gif.',
            'is_image'  => 'File is not an image.'
        ],
    ];

    /**
     *  Details from Image Uploads 
     */
    public $upload = [
        'title'     => 'required|alpha_numeric_punct|max_length[100]|min_length[1]|badWordsFilter[title]',
        'tags'      => 'required|regex_match[/^[\w\d, \-]+$/]|badWordsFilter[tags]',
    ];

    public $upload_errors = [
        'title' => [
            'required'              => 'Your image must contain a title.',
            'alpha_numeric_punct'   => '{field} must include only alphanumerics or ~, !, #, $, %, &, *, -, _, +, =, |, :, or .',
            'max_length'            => '{field} exceeds the character limit.',
            'min_length'            => '{field} does not contain enough characters.',
            'badWordsFilter'        =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'tags' => [
            'regex_match'       => '{field} must be separated by comma or space and contain only alphanumeric or space/comma input.',
            'badWordsFilter'    =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
    ];
    /**
     *  Comments
     */
    public $comments = [
        'comment_text'  => 'required|alpha_numeric_punct|max_length[250]|min_length[5]|badWordsFilter[comment_text]',
    ];

    public $comments_errors = [
        'comment_text'  => [
            'required'              => 'Your comment must contain some content.',
            'alpha_numeric_punct'   => 'Your comment must include only alphanumerics or ~, !, #, $, %, &, *, -, _, +, =, |, :, or .',
            'max_length'            => 'Your comment exceeds the character limit ({}).',
            'min_length'            => 'Your comment does not contain enough character ({})',
            'badWordsFilter'        => 'Your comment contains words which are inappropriate for some members. Please remove any profanity.',
        ],
    ];

    /**
     *  Date
     */
    public $date = [
        'date'  => 'validateDate[date]',
    ];

    public $date_errors = [
        'date' => [
            'validateDate'  => 'You have entered an invalid date.',
        ],
    ];

    /**
     *  Profile 
     */
    public $profile = [
        'occupation'    => 'permit_empty|max_length[50]|alpha_space|badWordsFilter[occupation]',
        'hometown'      => 'permit_empty|max_length[50]|alpha_space|badWordsFilter[hometown]',
        'country'       => 'permit_empty|badWordsFilter[about_me]',
    ];

    public $profile_errors = [
        'about_me' => [
            'max_length'            => '{field} must be shorter than {param} characters long.',
            'alpha_numeric_punct'   => '{field} must include only alphanumerics or ~, !, #, $, %, &, *, -, _, +, =, |, :, or .',
            'badWordsFilter'        =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'occupation' => [
            'max_length'        => '{field} must be shorter than {param} characters long.',
            'alpha_space'       => '{field} must contain only alpha or space values.',
            'badWordsFilter'    =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'hometown' => [
            'max_length'        => '{field} must be shorter than {param} characters long.',
            'alpha_space'       => '{field} must contain only alpha or space values.',
            'badWordsFilter'    =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
    ];

    /**
     *  Registration
     */
    public $registration = [
        'username'      => 'required|is_unique[users.username,username]|min_length[5]|max_length[25]|alpha_dash|badWordsFilter[username]',
        'password'      => 'required|min_length[8]|max_length[255]|regex_match[/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,255}$/]',
        'pass_confirm'  => 'required|matches[password]',
        'about_me'      => 'permit_empty|max_length[250]|alpha_numeric_punct|badWordsFilter[about_me]',
        'occupation'    => 'permit_empty|max_length[50]|alpha_space|badWordsFilter[occupation]',
        'hometown'      => 'permit_empty|max_length[50]|alpha_space|badWordsFilter[hometown]',
        'country'       => 'permit_empty|badWordsFilter[about_me]',
    ];

    public $registration_errors = [
        'username' => [
            'required'          => 'You must choose a {field}.',
            'is_unique'         => 'That {field} already exists.',
            'min_length'        => '{field} must be at least {param} characters long.',
            'max_length'        => '{field} must be shorter than {param} characters long.',
            'alpha_dash'        => '{field} must begin with an alpha and only contain alphanumeric plus - and _',
            'badWordsFilter'    => '{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'password' => [
            'required'      => 'You must choose a {field}.',
            'min_length'    => '{field} must be at least {param} characters long.',
            'max_length'    => '{field} must be shorter than {param} characters long.',
            'regex_match'   => '{field} must satisfy all of the following: Have at least 1 uppercase letter. Have at least 1 numeric value. Have at least 1 special character ! @ # $ % ^ &.',
        ],
        'pass_confirm' => [
            'required'  => 'You must confirm your password',
            'matches'   => 'Passwords do not match!',
        ],
        'about_me' => [
            'max_length'            => '{field} must be shorter than {param} characters long.',
            'alpha_numeric_punct'   => '{field} must include only alphanumerics or ~, !, #, $, %, &, *, -, _, +, =, |, :, or .',
            'badWordsFilter'        =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'occupation' => [
            'max_length'        => '{field} must be shorter than {param} characters long.',
            'alpha_space'       => '{field} must contain only alpha or space values.',
            'badWordsFilter'    =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'hometown' => [
            'max_length'        => '{field} must be shorter than {param} characters long.',
            'alpha_space'       => '{field} must contain only alpha or space values.',
            'badWordsFilter'    =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
        'country' => [
            'badWordsFilter'        =>'{field} contains words which are inappropriate for some members. Please remove any profanity.',
        ],
    ];

    /**
     *  Password Verification
     */
    public $login = [
        'password'      => 'required|validateUser[username,password]',
    ];
    
    public $login_errors = [
        'password' => [
            'required' => 'You must enter your {field}.',
            'validateUser' => 'Username or Password do not match our records.',
        ],
    ];
}   
