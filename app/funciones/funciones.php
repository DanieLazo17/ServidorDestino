<?php

    function generarContrasenaAleatoria(){
        $caracteresAlfanumericos = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $caracteresNumericos = "1234567890";
        $contrasenaAleatoria = null;

        for($i=0; $i<2; $i++) {
            $contrasenaAleatoria .= substr($caracteresAlfanumericos, rand(0,61), 1);
        }
        for($i=0; $i<2; $i++) {
            $contrasenaAleatoria .= substr($caracteresNumericos, rand(0,9), 1);
        }
        for($i=0; $i<3; $i++) {
            $contrasenaAleatoria .= substr($caracteresAlfanumericos, rand(0,61), 1);
        }
        for($i=0; $i<1; $i++) {
            $contrasenaAleatoria .= substr($caracteresNumericos, rand(0,9), 1);
        }
        return $contrasenaAleatoria;
    }

    function enviarCorreo($destinatario, $asunto, $mensaje){

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = getenv("Correo");                       //SMTP username
            $mail->Password   = getenv("ClaveDeCorreo");                //SMTP password
            $mail->SMTPSecure = 'TLS';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(getenv("Correo"), getenv("NombreDeCorreo"));
            $mail->addAddress($destinatario);                           //Add a recipient

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
            return '¡El mensaje se envió correctamente, revise su correo!';
        } catch (Exception $e) {
            return "Error al enviar mensaje: {$mail->ErrorInfo}";
        }
    }

    function iniciarSesion($nombreUsuario){

        $_SESSION['admin'] = $nombreUsuario;

        if( isset($_SESSION['admin'])){
            return 'perfil.php';
        }
        else{
            return 'login.html';
        }
    }

    function cerrarSesion(){
        // Inicializar la sesión.
        // Si está usando session_name("algo"), ¡no lo olvide ahora!
        session_start();

        // Destruir todas las variables de sesión.
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
        // Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión.
        session_destroy();

        return 'login.html';
    }

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