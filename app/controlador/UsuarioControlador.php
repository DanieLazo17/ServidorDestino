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
            $UsuarioRegistrado = array("idUsuario"=>null, "nombre"=>null);

            if(!$arregloDeUsuario){
                $response->getBody()->write(json_encode($UsuarioRegistrado));
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
                $UsuarioRegistrado = array("idUsuario"=>$arregloDeUsuario['idUsuario'], "nombre"=>$arregloDeUsuario['nombre']);
                $response->getBody()->write(json_encode($UsuarioRegistrado));
            }
            else{
                $response->getBody()->write(json_encode($UsuarioRegistrado));
            }

            return $response->withHeader('Content-Type', 'application/json');
        }
        
        //Comprobar si existe nombre de usuario en la misma base de datos
        public function BuscarNombreDeUsuario($request, $response, $args){
            
            $arregloUsuarios = Usuario::obtenerNombresDeUsuarios();

            $listaDeParametros = $request->getParsedBody();
            
            $resultado = in_array($listaDeParametros['usuarioNuevo'], array_column($arregloUsuarios, 'nombre'));

            if($resultado){
                $respuesta = ['estado' => true, 'mensaje' => 'Nombre de usuario duplicado'];
                $response->getBody()->write( json_encode($respuesta) );
            }
            else{
                $respuesta = ['estado' => false, 'mensaje' => 'Nombre de usuario correcto'];
                $response->getBody()->write( json_encode($respuesta) );
            }

            return $response->withHeader('Content-Type', 'application/json');
        }

        public function CrearUsuario($request, $response, $args){

            $listaDeParametros = $request->getParsedBody();
            $hashDeContrasena = password_hash($listaDeParametros['nuevaContra'], PASSWORD_DEFAULT);

            $usuario = new Usuario();
            $usuario->setCorreo($listaDeParametros['nuevoCorreo']);
            $usuario->setNombre($listaDeParametros['nuevoUsuario']);
            $usuario->setContrasena($hashDeContrasena);
            $nuevoUsuario = array("nombre"=>$usuario->getNombre());
            $usuario->guardarUsuario();

            if( isset($_FILES['nuevaFoto']) ){

                $usuario_nuevo = $listaDeParametros['nuevoUsuario'];
        
                $nombreFoto = 'subidas/' . $usuario_nuevo . substr($_FILES['nuevaFoto']['name'], -4);
                move_uploaded_file($_FILES['nuevaFoto']['tmp_name'], $nombreFoto);
            }

            $response->getBody()->write( json_encode($nuevoUsuario) );
            return $response->withHeader('Content-Type', 'application/json');
            //$response->getBody()->write("Usuario generado correctamente");
            //return $response;
        }

        public function RetornarUsuario($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();

            $arregloDeUsuario = Usuario::obtenerUsuario($listaDeParametros['nombre']);
            $UsuarioRegistrado = array("idUsuario"=>null, "nombre"=>null);

            if(!$arregloDeUsuario){
                $response->getBody()->write(json_encode($UsuarioRegistrado));
                return $response;
            }

            $UsuarioRegistrado = array("idUsuario"=>$arregloDeUsuario['idUsuario'], "nombre"=>$arregloDeUsuario['nombre']);
            $response->getBody()->write(json_encode($UsuarioRegistrado));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RecuperarContrasena($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            
            $objetoUsuario = Usuario::buscarCorreo($listaDeParametros['correo']);

            if(!$objetoUsuario){
                $response->getBody()->write("No existe correo");
                return $response;
            }
            
            $contrasenaNueva = generarContrasenaAleatoria();
            $hashDeContrasena = password_hash($contrasenaNueva, PASSWORD_DEFAULT);

            $ObjUsuario = new Usuario();
            $ObjUsuario->setIdUsuario($objetoUsuario->getIdUsuario());
            $ObjUsuario->setCorreo($objetoUsuario->getCorreo());
            $ObjUsuario->setContrasena($hashDeContrasena);
            $ObjUsuario->actualizarContrasena();
            $asunto = "Clave de Acceso";
            $mensaje = "Su clave nueva es: " . $contrasenaNueva;
        
            $respuesta = enviarCorreo($ObjUsuario->getCorreo(), $asunto, $mensaje);
            $ObjU = array("idUsuario"=>null, "clave"=>$contrasenaNueva);
            //$response->getBody()->write($respuesta);
            //return $response;
            $response->getBody()->write(json_encode($ObjU));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>