<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Users extends BaseController
{
    public function users_management()
    {
        $data = [];

        $crud = new GroceryCrud();


        $crud->setRelation('role', 'user_roles', 'role_name');


        $crud->setTable('users');

        $crud->columns(['firstname', 'lastname', 'email', 'role', 'activated', 'created_at', 'updated_at']);

        $crud->addfields(['firstname', 'lastname', 'email',  'role', 'activated', 'password']);
        $crud->editfields(['firstname', 'lastname', 'email',  'role', 'activated']);
        $crud->fieldType('password', 'password');

        $crud->requiredFields(['firstname', 'lastname', 'email', 'role', 'activated', 'password']);


        $crud->setRule('email', 'Email', 'required|valid_email');
        $crud->setRule('password', 'Password', 'required|min_length[6]');

        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data['password'] =
                password_hash($stateParameters->data['password'], PASSWORD_ARGON2ID);

            return $stateParameters;
        });

        $output = $crud->render();






        echo view('users', (array)$output);
    }
}
