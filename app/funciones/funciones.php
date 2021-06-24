<?php

    function mostrarValor($parametro="Prueba"){
        echo "<br>";
        echo $parametro;
        return 1;
    }

    function buscarNombreUsuario($nombreUsuario, $contrasenaUsuario){
        $usuarios = leerArchivoUsuarios();

        $usuariosArray = json_decode($usuarios);
        
        $resultado = array_search($nombreUsuario, array_column($usuariosArray, 'usuario'));

        if($resultado === false){
            return $resultado;
        }

        $tempUsuario = new Usuario();
        $tempUsuario->setNombre($usuariosArray[$resultado]->{"usuario"});
        $tempUsuario->setContrasena($usuariosArray[$resultado]->{"contrasena"});

        if($tempUsuario->getContrasena() == $contrasenaUsuario){
            $resultado = true;
            return $resultado;
        }
    }

    function leerArchivo($nombreArchivo){

        $archivo = fopen($nombreArchivo,"r");

        $contrasenaEnArchivo = fread($archivo,filesize($nombreArchivo));

        fclose($archivo);

        return $contrasenaEnArchivo;
    }

    function compararContrasena($contrasenaEnArchivo, $contrasenaIngresada){

        $estado = false;

        if($contrasenaEnArchivo == $contrasenaIngresada){
            $estado = true;
        }

        return $estado;
    }

    function leerArchivoUsuarios(){

        $archivo = fopen('Subidas/usuarios.json',"r");
        $usuarios = fread($archivo,filesize('Subidas/usuarios.json'));
        fclose($archivo);

        return $usuarios;
    }

    function escribirArchivoUsuarios($usuariosString){

        $archivo = fopen('Subidas/usuarios.json',"w");
        fwrite($archivo, $usuariosString);
        fclose($archivo);
    }

    function buscarUsuario($nombreUsuario){

        $usuarios = leerArchivoUsuarios();

        $usuariosArray = json_decode($usuarios);
        //var_dump($usuariosArray);
        //var_dump(array_search($nombreUsuario, array_column($usuariosArray, 'usuario')));
        $resultado = in_array($nombreUsuario, array_column($usuariosArray, 'usuario'));

        return $resultado;
    }

    function agregarUsuario($usuario, $contrasena){

        $usuarios = leerArchivoUsuarios();
        //var_dump($usuarios);

        $usuariosArray = json_decode($usuarios);

        $tempUsuario = new Usuario();

        $tempUsuario->setNombre($usuario);
        $tempUsuario->setContrasena($contrasena);

        array_push($usuariosArray, $tempUsuario);
        var_dump($usuariosArray);

        $usuariosString = json_encode($usuariosArray);

        escribirArchivoUsuarios($usuariosString);
    }

?>