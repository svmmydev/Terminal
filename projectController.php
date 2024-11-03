<?php

// Archivos incluidos
include "errorController.inc.php";
include "DirectoryManager.php";
include "FileManager.php";
include "SystemManager.php";

session_start();

$barra = DIRECTORY_SEPARATOR; // Separador para rutas
$currentPath = getcwd().$barra."terminalDirectory".$barra; // Ruta específica de carpeta contenedora

$directories = new DirectoryManager(); // 
$files = new FileManager();            // Instancias para usar en parámetros
$system = new SystemManager();         //

// Se comprueba si el formulario se ha usado
if(isset($_POST["instructionSent"])) {

    $_SESSION["form_submitted"] = true;  // Marcar formulario como enviado
    $_SESSION["showHelpMessage"] = false; // Ocultar mensaje de bienvenida
    $instruction = explode(" ", $_POST["instructionSent"]);

    // Se comprueba el parámetro introducido
    if ($instruction = checkParams($instruction)) {
        
        $action = $instruction[0];            //
        $parameter = trim($instruction[1]);   // Se almacenan los parámetros
        $parameter2 = trim($instruction[2]);  //
        $parameter3 = trim($instruction[3]);  //

            if (isset($_POST["instructionSent"])) {
                $_SESSION["form_submitted"] = true; // Marcar el formulario como enviado
                $_SESSION["showHelpMessage"] = false; // Ocultar el mensaje de bienvenida
            
                // Se clasifica por parámetro $action
                switch($action) {
                    case "mkdir":
                        $result = handleCreation($currentPath, $instruction, $action, $parameter, $directories, $files, "directory");   //
                        break;                                                                                                          // Se llama al mismo método introduciendo la clave
                    case "touch":                                                                                                       // tipo por parámetro (directory/file)
                        $result = handleCreation($currentPath, $instruction, $action, $parameter, $directories, $files, "file");        //
                        break;
                    case "modtime":
                        $result = lastMod($currentPath, $parameter, $directories); // Se llama al método para la última modificación de carpeta
                        break;
                    case "stats":
                        $result = fileStatus($currentPath, $parameter, $files); // Se llama al método para el estado de un archivo
                        break;
                    case "find":
                        $result = displayFindFile($currentPath, $parameter, $files); // Se llama al método para mostrar archivo encontrado
                        break;
                    case "permfile":
                        $result = checkPermissions($currentPath, $parameter, $files); // Se llama al método para comprobar los permisos de un archivo
                        break;
                    case "ls":
                        $result = displayAllPaths($system); // Se llama al método para mostrar todas las rutas comunes
                        break;
                    case "pwd":
                        $result = displaySystemPath($system); // Se llama al método para conocer la ruta donde está actuando el sistema
                        break;
                    case "df":
                        $result = displayDiskSpace($currentPath, $system); // Se llama al método para comprobar la memoria total, usada y libre del sistema
                        break;
                    case "osinfo":
                        $result = displayOSInfo($system); // Se llama al método para mostrar la información del equipo que está siendo en uso (Windows, Ubuntu, Macos..)
                        break;
                    case "rm":                                                                                                                                          //
                    case "mv":                                                                                                                                          // Se llama al mismo método en todos los casos 
                    case "cp":                                                                                                                                          // para manejar la acción
                    case "vim":                                                                                                                                         //  
                        $result = handleCommand($currentPath.DIRECTORY_SEPARATOR, $instruction, $action, $parameter, $parameter2, $parameter3, $directories, $files);   //
                        break;
                    case "--help":
                        $result = displayHelp($instruction, $action, $parameter); // Se llama al método para mostrar el mensaje de ayuda
                        break;
                    default:
                        $result = ERROR_SIGNAL."Comando inválido,".COMMAND_HELP;
                        break;
                }
            } else {
                $result = ERROR_SIGNAL."Los comandos no pueden contener caracteres inválidos,".COMMAND_HELP;
            }
        }
        

    $historyFile = "feed.txt";
    $commandLine = implode(" ", $instruction);
        
    $newEntry = GREEN1."$".GREEN2." terminal > ".$commandLine.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.$result. // Se almacena cada acción en la feed
                PHP_EOL.PHP_EOL.PHP_EOL.GREY1."---------------".GREY2.PHP_EOL.PHP_EOL.PHP_EOL;         //
        
    $currentContent = file_exists($historyFile) ? file_get_contents($historyFile) : "";
        
    file_put_contents($historyFile, $newEntry.$currentContent);

}

$_SESSION["result"] = $result; // Se almacena el resultado en una variable de la sesión

header("location: index.php"); // Se vuelve a la página princpipal (index.php)
exit();
?>