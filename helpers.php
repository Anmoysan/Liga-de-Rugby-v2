<?php

function dameDato($dato){
    echo '<pre>';
    print_r($dato);
    echo '</pre>';
    die();
}

function imagenExiste($url){
    $web=getimagesize($url);
        if(!is_array($web)){
            $url = "https://vignette.wikia.nocookie.net/linux/images/8/84/Sin_imagen_disponible.jpg/revision/latest?cb=20160321215614&path-prefix=es";
        }
    return $url;
}