<?php

function dameDato($dato){
    echo '<pre>';
    print_r($dato);
    echo '</pre>';
    die();
}

function convierteCadena($array){
    return implode(", ", $array);
}

function convierteArray($string){
    return explode(", ", $string);
}

/**
 * Este helper sirve para generar los selects dinámicamente.
 *
 * @param $listaValores Array con los valores que debe mostrar el select
 * @param $seleccionados Array con los valores que debe seleccionar el select
 * @param $name String nombre de la clave que se pasará en el array $_POST
 * @param bool $multiple Bool Si el select va a admitir selección múltiple o no.
 *
 * @return string Código HTML del select
 */
function generarSelect($listaValores, $seleccionados, $name, $multiple = false){
    $salida = '<select class="form-control" name="'.$name.($multiple?"[]":""). '"' . ($multiple?"multiple":"") .'>';

    if( !is_array($seleccionados) ){
        $seleccionados = (array) $seleccionados;
    }

    foreach ($listaValores as $valor){
        $selected = "";
        if( in_array($valor, $seleccionados) ) $selected = " selected";
        $salida .= "<option value=\"{$valor}\"{$selected}>{$valor}</option>";
    }

    $salida .= '</select>';

    return $salida;
}

/**
 * Esta función genera un bloque de alerta para mostrar cuando se producen errores de validación.
 *
 * @param $errors       Array con la información de los errores
 * @param $field        String con el nombre del campo a evaluar
 * @return null|string  Código HTML del error
 */
function generarAlert($errors, $field){
    // Si hay errores en ese campo:
    if( isset($errors[$field]) ){
        // Se crea un string con la lista de errores
        $errorList = '';
        foreach ($errors[$field] as $error) {
            $errorList .= "{$error}<br>";
        }

        // Y se inserta dicha lista en un bloque alert (ver documentación bootstrap 3.3.7)
        $alert = <<<ALERT
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>{$errorList}</strong>
                </div>
ALERT;
    }else{
        $alert = null;
    }

    return $alert;
}