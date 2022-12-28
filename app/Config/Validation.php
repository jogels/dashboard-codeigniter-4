<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

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
        \Myth\Auth\Authentication\Passwords\ValidationRules::class


    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    public $register = [
        'username' => 'alpha_numeric|is_unique[user.username]',
        'password' => 'min_length[3]|alpha_numeric_punct',
        'confirmpassword' => 'matches[password]'
    ];

    public $register_errors = [
        'username' => [
            'alpha_numeric' => 'Username hanya boleh mengandung huruf dan angka',
            'is_unique' => 'Username sudah dipakai'
        ],
        'password' => [
            'min_length' => 'Password harus terdiri dari 3 kata',
            'alpha_numeric_punct' => 'Password hanya boleh mengandung angka, huruf, dan karakter yang valid'
        ],
        'confirmpassword' => [
            'matches' => 'Konfirmasi password tidak cocok'
        ]
    ];
}
