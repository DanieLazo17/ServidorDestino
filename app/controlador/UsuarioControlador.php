<?php

    /*
        El controlador maneja cada una de las llamadas o solicitudes.
        El objeto de la clase usuarioControlador realiza cada una de las funciones que necesitamos para que funcione nuestra aplicación.
    
        En la clase controlador, creamos funciones de acuerdo a qué funcionamiento le damos a una llamada o solicitud
    */

    //Funcionalidad

    class UsuarioControlador{

        public function ValidarUsuario($request, $response, $args){
            
            $listaDeParametros = $request->getParsedBody();

            $arregloUsuario = Usuario::obtenerUsuario($listaDeParametros['nombre']);

            if(!$arregloUsuario){
                $response->getBody()->write("No existe usuario");
                return $response;
            }
    
            if($arregloUsuario->compararContrasena($listaDeParametros['contrasena'])){
                $response->getBody()->write("Acceso correcto");
            }
            else{
                $response->getBody()->write("Contraseña incorrecta");
            }

            return $response;
        }

        public function BuscarNombreDeUsuario($request, $response, $args){

            $arregloUsuarios = Usuario::obtenerNombresDeUsuarios();

            $listaDeParametros = $request->getParsedBody();
            
            $resultado = in_array($listaDeParametros['usuarioNuevo'], array_column($arregloUsuarios, 'nombre'));

            if($resultado){
                $response->getBody()->write("Nombre de usuario duplicado");
            }
            else{
                $response->getBody()->write("Nombre de usuario correcto");
            }

            return $response;
        }

        public function CrearUsuario($request, $response, $args){

            $listaDeParametros = $request->getParsedBody();
            $hashDeContrasena = password_hash($listaDeParametros['nuevaContra'], PASSWORD_DEFAULT);

            $usuario = new Usuario();
            $usuario->setNombre($listaDeParametros['nuevoUsuario']);
            $usuario->setContrasena($hashDeContrasena);

            $usuario->guardarUsuario();

            if( isset($_FILES['nuevaFoto']) ){

                $usuario_nuevo = $listaDeParametros['nuevoUsuario'];
        
                $nombreFoto = 'subidas/' . $usuario_nuevo . substr($_FILES['nuevaFoto']['name'], -4);
                move_uploaded_file($_FILES['nuevaFoto']['tmp_name'], $nombreFoto);
            }

            $response->getBody()->write( json_encode($usuario) );

            return $response;
        }

    }

?>