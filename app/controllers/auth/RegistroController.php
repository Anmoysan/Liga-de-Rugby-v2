<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Usuario;
use Sirius\Validation\Validator;

class RegistroController extends BaseController {

    public function getRegistro(){
        return $this->render('auth/registro.twig',[]);
    }

    public function postRegistro(){
        $errors = [];
        $validator = new Validator();

        $validator->add('nombre:Nombre', 'required', [], 'El {label} es obligatorio');
        $validator->add('nombre:Nombre', 'minlength', ['min' => 5], 'El {label} debe tener al menos 5 caracteres');
        $validator->add('email:Email', 'required', [], 'El {label} es obligatorio');
        $validator->add('email:Email', 'email', [], 'No es un email válido');
        $validator->add('password1:Password', 'required', [], 'La {label} es requerida');
        $validator->add('password1:Password', 'minlength', ['min' => 8], 'La {label} debe tener al menos 8 caracteres');
        $validator->add('password2:Password', 'required', [], 'La {label} es requerida');
        $validator->add('password2:Password', 'match', 'password1', 'Las passwords deben coincidir');

        if($validator->validate($_POST)){
            $usuario = new Usuario();

            $usuario->nombre = $_POST['nombre'];
            $usuario->email = $_POST['email'];
            $usuario->password = password_hash($_POST['password1'], PASSWORD_DEFAULT);

            $usuario->save();

            header('Location: '.BASE_URL);
        }else{
            $errors = $validator->getMessages();
        }

        return $this->render('auth/registro.twig', ['errors' => $errors]);
    }
}