<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    public function register()
    { //traitons notre formulaire
        // if (form::isValide($_POST, ['lastname', 'firstname', 'email', 'password'])) {
        //     $lastname = htmlspecialchars($_POST['lastname']);
        //     $firstname = htmlspecialchars($_POST['firstname']);
        //     $email = htmlspecialchars($_POST['email']);
        //     $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


        //     $user = new UsersModel();
        //     $user->setLastname($lastname);
        //     $user->setFirstname($firstname);
        //     $user->setEmail($email);
        //     $user->setPassword($password);
        //     $user->create();
        // }


        $form = new Form();

        $form->beginForm()
            ->label('lastname', 'Nom',)
            ->input('text', 'lastname', 'lastname', '', [
                'class' => 'form-control'
            ])
            ->label('firstname', 'Prenom')
            ->input('text', 'firstname', 'firstname', '', [
                'class' => 'form-control'
            ])
            ->label('email', 'E-mail:')
            ->input('email', 'email', 'email', '', [
                'class' => 'form-control'
            ])
            ->label('password', 'Mot de passe')
            ->input('password', 'password', 'password', '', [
                'class' => 'form-control'
            ])
            ->input('submit', 'envoyer', 'envoyer', 'envoyer', [])
            ->endForm();

        var_dump($form);
        die();
        $this->render('users/register.php', [
            'form' => $form->createForm(),
        ]);
    }
}
