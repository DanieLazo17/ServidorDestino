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

            /*$objetoUsuario = Usuario::obtenerUsuario($listaDeParametros['nombre']);*/
            $arregloDeUsuario = Usuario::obtenerUsuario($listaDeParametros['nombre']);

            if(!$arregloDeUsuario){
                $response->getBody()->write("No existe usuario");
                return $response;
            }

            $objetoUsuario = new Usuario();
            $es = "set";

            foreach ($arregloDeUsuario as $atr => $valueAtr) {
                        
                $es = $es . ucfirst($atr);
                $objetoUsuario->{$es}($valueAtr);
                $es = "set";
                        
            }
    
            if($objetoUsuario->compararContrasena($listaDeParametros['contrasena'])){
                $response->getBody()->write("Acceso correcto");
            }
            else{
                $response->getBody()->write("Contraseña incorrecta");
            }

            /*
            if( count($arregloDeUsuario) == 1 ){
                
                $objetoUsuario = new Usuario();
                $es = "set";

                foreach($arregloDeUsuario as $objetoDeTipoUsuario){

                    foreach ($objetoDeTipoUsuario as $atr => $valueAtr) {

                        //$objetoUsuario->{$atr} = $valueAtr;
                        
                        $es = $es . ucfirst($atr);
                        $objetoUsuario->{$es}($valueAtr);
                        $es = "set";
                        
                    }
                }

                if($objetoUsuario->compararContrasena($listaDeParametros['contrasena'])){
                    
                    $response->getBody()->write("perfil.php");
                }
                else{
                    $response->getBody()->write("Contraseña incorrecta");
                }
            }
            else{
                $response->getBody()->write("Usuario incorrecto");
            }
            */
            return $response;
        }
        
        //Comprobar si existe nombre de usuario en la misma base de datos
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

            //$response->getBody()->write( json_encode($usuario) );
            $response->getBody()->write("Usuario generado correctamente");
            return $response;
        }

    }

?>