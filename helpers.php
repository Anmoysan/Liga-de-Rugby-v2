<?php

/**
 * Funncion que devuelve los valores de un dato introducido
 * @param $dato - Dato del cual se quiere saber sus datos
 */
function dameDato($dato){
    echo '<pre>';
    print_r($dato);
    echo '</pre>';
    die();
}

/**
 * Funcion que comprueba que la imagen existe, si no existe se pondra una imagen por defecto
 * @param $url - Imagen introducida
 * @return string - Imagen introducida si es correcta o la imagen por defecto
 */
function imagenExiste($url){
    $web=getimagesize($url);
        if(!is_array($web)){
            $url = "https://vignette.wikia.nocookie.net/linux/images/8/84/Sin_imagen_disponible.jpg/revision/latest?cb=20160321215614&path-prefix=es";
        }
    return $url;
}