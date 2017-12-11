<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Log;
use App\Models\Usuario;
use Sirius\Validation\Validator;

class LoginController extends BaseController {

    public function getLogin(){
        return $this->render('auth/login.twig',[]);
    }

    public function postLogin(){
        $validator = new Validator();

        $validator->add('email:Email', 'required', [], 'El {label} es requerido');
        $validator->add('email:Email', 'email',[],'No es un email válido');
        $validator->add('password:Password', 'required',[],'La {label} es requerida.');

        if($validator->validate($_POST)){
            $usuario = Usuario::where('email', $_POST['email'])->first();
            if(password_verify($_POST['password'], $usuario->password)){
                $_SESSION['userId'] = $usuario->id;
                $_SESSION['userNombre'] = $usuario->nombre;
                $_SESSION['userEmail'] = $usuario->email;

                header('Location: '. BASE_URL);
                return null;
            }

            $validator->addMessage('authError','Los datos son incorrectos');
        }

        Log::logInfo('Intento fallido de login '. $_POST['email']);

        $errors = $validator->getMessages();

        return $this->render('auth/login.twig', [
            'errors' => $errors
        ]);
    }

    public function getLogout(){
        //session_destroy();
        unset($_SESSION['userId']);
        unset($_SESSION['userNombre']);
        unset($_SESSION['userEmail']);

        header("Location: ". BASE_URL);
    }
}