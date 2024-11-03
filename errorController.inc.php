<?php

include "help.inc.php"; // Incluye el archivo de ayuda

const ERROR_SIGNAL = "<span style='color: red;'>[x] </span>";                                        //
const OK_SIGNAL = "<span style='color: green;'>[✓] </span>";                                         //
const NAME_CONFLICT = ERROR_SIGNAL."Ya existe un elemento con ese nombre en la misma ubicación.";    // Constantes para uso de mensajes
const ERROR_MESSAGE = ERROR_SIGNAL."Ha ocurrido un error ";                                          //
const PATH_ERROR = ERROR_SIGNAL."La carpeta destino especificada no existe.";                        //
const COMMAND_HELP = " puedes ver la lista de comandos introduciendo '".GREEN1."--help".GREEN2."'.";  //

/**
 * Maneja la creación del elemento en base al tipo introducido (file/direcoty) por parámetro.
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del elemento a crear.
 * @param array $instruction Colección de instrucciones.
 * @param string $action Comando de la instrucción.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @param object $directories Objeto instanciado de la clase DirectoryManager.
 * @param object $files Objeto instanciado de la clase FileManager.
 * @param string $type Tipo de elemento en cuestión.
 * @return string Mensaje a mostrar.
 */
function handleCreation($path, $instruction, $action, $parameter, $directories, $files, $type) {
    $targetPath = $path.$parameter;

    $paramHelp = "El comando '".GREEN1.$action.GREEN2."' necesita un parámetro válido";
    
    if (count($instruction) == 2) {
        if (!file_exists($targetPath)) {
            if ($type == "directory") {
                return ($directories->createDirectory($targetPath)) ? OK_SIGNAL."Se ha creado la carpeta." : PATH_ERROR;
            } elseif ($type == "file") {
                return ($files->createFile($targetPath)) ? OK_SIGNAL."Se ha creado el archivo." : PATH_ERROR;
            }
        } else {
            return NAME_CONFLICT;
        }
    } else {
        return ERROR_SIGNAL."$paramHelp, ".COMMAND_HELP;
    }
}

/**
 * Maneja las acciones "vim", "cp", "rm", o "mv". Filtrando entre archivos y carpetas.
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del elemento a manejar.
 * @param array $instruction Colección de instrucciones.
 * @param string $action Comando de la instrucción.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @param string $parameter2 Parámetro '2' de la instrucción.
 * @param string $parameter3 Parámetro '3' de la instrucción.
 * @param object $directories Objeto instanciado de la clase DirectoryManager.
 * @param object $files Objeto instanciado de la clase FileManager.
 * @return string Mensaje a mostrar.
 */
function handleCommand($path, $instruction, $action, $parameter, $parameter2, $parameter3, $directories, $files) {
    $paramHelp = "El comando '".GREEN1.$action.GREEN2."' necesita un parámetro válido";

    $targetPath = $path.$parameter2;
    $destinationPath = $path.$parameter3;

    $elementName = basename($parameter2);

    // Manejo de la acción "vim"
    if ($action == "vim") {
        $targetPathVim = $path.$parameter;    // Define las rutas
        $targetPatVimAdd = $path.$parameter2; //

        // Controla si se elige modificar el archivo añadiendo líneas
        if (count($instruction) >= 3) {
            if ($parameter == "-a") {
                $files->saveFileAddLine($targetPatVimAdd, $parameter3);

                return $targetPath !== false ? "Contenido del archivo:<br><br>".nl2br(file_get_contents($targetPatVimAdd)) : ERROR_SIGNAL."No se ha podido modificar el archivo.";
            }

            // Modifica el archivo en caso de querer sobreescribir
            $files->saveFile($targetPathVim, $parameter2);

            return $targetPath !== false ? "Contenido del archivo:<br><br>".nl2br(file_get_contents($targetPathVim)) : ERROR_SIGNAL."No se ha podido modificar el archivo.";

        // Crea únicamente el archivo si no se introduce ningún contenido en el parámetro
        } elseif (count($instruction) == 2 && !is_file($targetPathVim)) {
            return $files->saveFile($targetPathVim, $parameter3) ? OK_SIGNAL."Se ha creado el archivo." : ERROR_SIGNAL."No se ha podido crear el archivo.";

        } else {
            return NAME_CONFLICT;
        }
    }

    // Manejo de las acciones "rm", "cp" o "mv" dependiendo del parámetro
    switch($parameter) {
        case "-d":
            if(!is_dir($targetPath)) {
                return ERROR_SIGNAL."La carpeta '".GREEN1.$elementName.GREEN2."' no existe en esa ruta indicada.";
            }
            
            // Controla selección de acción y número de parámetros
            if ($action == "rm" && count($instruction) == 3) {
                return $directories->deleteDirectory($targetPath) ? OK_SIGNAL."Se ha eliminado la carpeta." : ERROR_MESSAGE."a la hora de eliminar la carpeta.";
            }

            // Controla número de parámetros (actual/destino)
            if (count($instruction) == 4) {
                if (!is_dir($destinationPath)) {
                    switch ($action) {
                        case "mv":
                            return $directories->moveDirectory($targetPath, $destinationPath) ? OK_SIGNAL."La carpeta se ha movido con éxito." : PATH_ERROR;
                        case "cp":
                            return $directories->copyDirectory($targetPath, $destinationPath) ? OK_SIGNAL."Se ha copiado la carpeta con éxito." : PATH_ERROR;
                    }
                } else {
                    return NAME_CONFLICT;
                }
            }
            break;
        case "-f":
            if(!is_file($targetPath)) {
                return ERROR_SIGNAL."El archivo '".GREEN1.$elementName.GREEN2."' no existe en esa ruta indicada.";
            }

            if (is_file($targetPath)) {
                // Controla selección de acción y número de parámetros
                if ($action == "rm" && count($instruction) == 3) {
                    return $files->deleteFile($targetPath) ? OK_SIGNAL."Se ha eliminado el archivo con éxito." : PATH_ERROR;
                }

                // Controla número de parámetros (actual/destino)
                if (count($instruction) == 4) {
                    if (!is_file($destinationPath)) {
                        switch ($action) {
                            case "mv":
                                return $files->moveFile($targetPath, $destinationPath) ? OK_SIGNAL."Se ha movido el archivo con éxito." : PATH_ERROR;
                            case "cp":
                                return $files->copyFile($targetPath, $destinationPath) ? OK_SIGNAL."Se ha copiado el archivo con éxito." : PATH_ERROR;
                        }
                    } else {
                        return NAME_CONFLICT;
                    }
                }
            }
            break;
        default:
            return ERROR_SIGNAL."$paramHelp, ".COMMAND_HELP;
    }
    return ERROR_SIGNAL."Se necesitan parámetros válidos,".COMMAND_HELP;
}

/**
 * Comprueba la hora y fecha de la última modificación de la carpeta.
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del elemento a manejar.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @param object $directories Objeto instanciado de la clase DirectoryManager.
 * @return string Mensaje a mostrar.
 */
function lastMod($path, $parameter, $directories) {
    $targetPath = $path.$parameter;

    if ($timeCapture = $directories->getDirectoryModificationTime($targetPath)) {
        return "Última modificación: $timeCapture (Carpeta)";
    } else {
        return ERROR_SIGNAL."La carpeta indicada no existe en la ruta indicada.";
    }
}

/**
 * Comprueba el estado del archivo indicado (Última modificación y tamaño del archivo).
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del archivo a manejar.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @param object $files Objeto instanciado de la clase FileManager.
 * @return string Mensaje a mostrar.
 */
function fileStatus($path, $parameter, $files) {
    $targetPath = $path.$parameter;

    $fileNameArray = explode(DIRECTORY_SEPARATOR, $parameter);
    $fileName = end($fileNameArray);

    if(!file_exists($targetPath) || is_dir($targetPath)) {
        return ERROR_SIGNAL."El archivo '".GREEN1.$fileName.GREEN2."' no existe en la ruta indicada.";
    }

    if ($stats = $files->getFileStatus($targetPath)) {
        return GREEN1."Nombre del archivo".GREEN2.": ".basename($targetPath)."<br><br>
                ".GREEN1."Tamaño".GREEN2.": ".$stats['size']." bytes<br><br>
                ".GREEN1."Última modificación".GREEN2.": ". date("d-m-Y H:i", $stats['modified']);
    }
}

/**
 * Muestra el mensaje resultante de la llamada al método findFile().
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del elemento a manejar.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @param object $files Objeto instanciado de la clase FileManager.
 * @return string Mensaje a mostrar.
 */
function displayFindFile($path, $parameter, $files) {
    $result = findFile($path, $parameter, $files);

    if ($result == null) {
        return ERROR_SIGNAL."El archivo '".GREEN1.$parameter.GREEN2."' no existe en la ruta indicada.";
    }

    return $result;
}

/**
 * Permite buscar un archivo mediante iteraciones con el método 'ORC',
 * Open, Read, Close.
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del elemento a manejar.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @param object $files Objeto instanciado de la clase FileManager.
 * @return mixed null | string Mensaje dependiendo de si lo ha encontrado o no.
 */
function findFile($path, $parameter, $files) {
    if ($dh = opendir($path)) {
        while (($element = readdir($dh)) !== false) {
            if ($element == '.' || $element == '..') {
                continue;
            }

            if (basename($path) == "terminalDirectory") {
                $fullPath = $path.$element;
            } else {
                $fullPath = $path.DIRECTORY_SEPARATOR.$element;
            }

            if ($files->searchFile($fullPath) && basename($fullPath) == $parameter) {
                closedir($dh);
                return OK_SIGNAL."El archivo existe en la ruta indicada:<br><br><br>--> "
                    .GREEN1.$fullPath.GREEN2." <--";
            }

            if (is_dir($fullPath)) {
                $result = findFile($fullPath, $parameter, $files);

                if ($result) {
                    closedir($dh);
                    return $result;
                }
            }
        }
        closedir($dh);
    }

    return null;
}

/**
 * Muestra la memoria total, usada o libre del sistema. Lo muestra tanto en
 * GB como en MB (redondeando).
 * Así como su control de errores.
 * 
 * @param string $path Ruta del directorio (valor por defecto "/").
 * @param object $system Objeto instanciado de la clase SystemManager.
 * @return string Mensaje a mostrar.
 */
function displayDiskSpace($path = "/", $system) {
    $dir = basename($path);

    if (is_dir($path)) {
        $diskSpace = memoryConversor($path, $system);

        return "Memoria del sistema:<br><br>
                - ".GREEN1."Espacio TOTAL".GREEN2.": ".round($diskSpace["totalGB"])." GB / ".round($diskSpace["totalMB"])." MB<br><br>
                - ".GREEN1."Espacio USADO".GREEN2.": ".round($diskSpace["usedGB"])." GB / ".round($diskSpace["usedMB"])." MB -> ".round($diskSpace["usedPercent"]).GREEN1."%".GREEN2."<br><br>
                - ".GREEN1."Espacio LIBRE".GREEN2.": ".round($diskSpace["freeGB"])." GB / ".round($diskSpace["freeMB"])." MB -> ".round($diskSpace["freePercent"]).GREEN1."%".GREEN2;
    } else {
        return ERROR_SIGNAL."El directorio '".GREEN1.$dir.GREEN2."' no existe en la ruta indicada.";
    }
}

/**
 * Comprueba las medidas de memoria del total, usado y espacio libre del sistema
 * indicado.
 * Así como su control de errores.
 * 
 * @param string $path Ruta del sistema a comprobar.
 * @param object $system Objeto instanciado de la clase SystemManager.
 * @return array $diskspace Colección de las medidas de memoria.
 */
function memoryConversor($path, $system) {
    $diskSpace = $system->getSystemStatus($path);

    $totalSpaceGB = $diskSpace["total_space"] / pow(1024, 3);
    $usedSpaceGB = $diskSpace["used_space"] / pow(1024, 3);
    $freeSpaceGB = $diskSpace["free_space"] / pow(1024, 3);

    $totalSpaceMB = $diskSpace["total_space"] / (pow(1024, 2));
    $usedSpaceMB = $diskSpace["used_space"] / pow(1024, 2);
    $freeSpaceMB = $diskSpace["free_space"] / pow(1024, 2);

    $usedPercent = ($diskSpace["used_space"] / $diskSpace["total_space"]) * 100;
    $freePercent = ($diskSpace["free_space"] / $diskSpace["total_space"]) * 100;

    $diskSpace = [
        "totalGB" => $totalSpaceGB,
        "usedGB" => $usedSpaceGB,
        "freeGB" => $freeSpaceGB,
        "totalMB" => $totalSpaceMB,
        "usedMB" => $usedSpaceMB,
        "freeMB" => $freeSpaceMB,
        "usedPercent" => $usedPercent,
        "freePercent" => $freePercent
    ];

    return $diskSpace;
}

/**
 * Comprueba los permisos de un archivo.
 * Así como su control de errores.
 * 
 * @param string $path Ruta/nombre del elemento a manejar.
 * @param string $parameter Parámetro '1' de la instrucción.
 * @return string Mensaje a mostrar.
 */
function checkPermissions($path, $parameter, $files) {
    $targetPath = $path.$parameter;

    if (is_file($targetPath)) {
        $permissions = $files->filePermissions($targetPath);
        return "Permisos de '$parameter':<br><br>
                - ".GREEN1."Legible".GREEN2." --> ".($permissions["readable"] ? "Sí" : "No")."<br>
                - ".GREEN1."Escribible".GREEN2." --> ".($permissions["writable"] ? "Sí" : "No")."<br>
                - ".GREEN1."Ejecutable".GREEN2." --> ".($permissions["executable"] ? "Sí" : "No");
    } else {
        return ERROR_SIGNAL."El archivo '".GREEN1."$parameter".GREEN2."' no existe en la ruta indicada.";
    }
}

/**
 * Muestra todas las rutas comunes del sistema.
 * Así como su control de errores.
 * 
 * @param object Objeto instanciado de la clase StystemManager.
 * @return string Rutas comunes a mostrar.
 */
function displayAllPaths($system) {
    $allPaths = $system->listSystemPaths();
    $output = "";

    foreach ($allPaths as $path) {
        if ($path == "/") continue;
        $output .= "- ".GREEN1."[".GREEN2.$path.GREEN1."]".GREEN2."<br><br>";
    }

    return "Rutas:<br><br>".$output;
}

/**
 * Muestra el resultado de la llamada al método getSystemPath().
 * Así como su control de errores.
 * 
 * @param object Objeto instaciado de la clase SystemManager.
 * @return string Ruta del sistema actual.
 */
function displaySystemPath($system) {
    $path = $system->getSystemPath();

    return "La ruta del sistema es la siguiente:<br><br>--> "
        .GREEN1.$path.GREEN2." <--";
}

/**
 * Muestra el resultado de la llamada al método getOSInfo().
 * Así como su control de errores.
 * 
 * @param objeto Objeto isntanciado de la clase SystemManager.
 * @return string Mensaje a mostrar.
 */
function displayOSInfo($system) {
    $OSinfo = $system->getOSInfo();

    return GREEN1."Información del sistema".GREEN2.":<br><br>
            $OSinfo";
}

/**
 * Comprueba cómo se ha realizado la entrada de "vim", y según la operación,
 * se añadirá una linea al document seleccionado o se sobreescribirá.
 * Así como su control de errores.
 * 
 * @param array $instruction Colección de los parámetros entrantes.
 * @return mixed false | array Un array según los parámetros introducidos.
 */
function vimValidate($instruction) {
    $fullContent = "";

    if (count($instruction) == 2) {
        return $instruction;
    }
    
    if ($instruction[1] == "-a") {
        for ($i = 3; $i < count($instruction); $i++) {
            $fullContent .= $instruction[$i]." ";
        }
    
        $fullContent = trim($fullContent);

        return [$instruction[0], $instruction[1], $instruction[2], $fullContent];

    } else {
        for ($i = 2; $i < count($instruction); $i++) {
            $fullContent .= $instruction[$i]." ";
        }
    
        $fullContent = trim($fullContent);
    
        if (empty($fullContent)) {
            return false;
        }
    
        return [$instruction[0], $instruction[1], $fullContent];

    }
}

/**
 * Muestra los archivos de ayuda.
 * 
 * @param array $instruction Colección de los parámetros entrantes.
 * @param string $action Comando de la instrucción.
 * @param string $parameter Parámetro de la instrucción.
 */
function displayHelp($instruction, $action, $parameter) {
    $paramHelp = "El comando '".GREEN1.$action.GREEN2."' necesita un parámetro válido";

    $helpContent = helpCommandsIndividual();

    if (count($instruction) == 2 && array_key_exists($parameter, $helpContent)) {
        return $helpContent[$parameter];
    
    } else if (count($instruction) == 1) {
          return helpCommands();
    } else {
        return ERROR_SIGNAL.$paramHelp.".";
    }
}

/**
 * Aplica un filtro "regex" y comprueba si los comandos introducidos.
 * tienen un formato válido.
 * Así como su control de errores.
 * 
 * @param array $instruction Colección de los parámetros entrantes.
 * @return mixed array | false Un array si pasa el control regex, falso en caso contrario.
 */
function checkParams($instruction) {
    $pattern = '#^(?=.*[^\s"\'-])[a-zA-Z0-9_"\'\/.-]+$#';

    if ($instruction[0] === "vim") {
        return $instruction = vimValidate($instruction);
    }

    foreach($instruction as $param) {
        if (!preg_match($pattern, $param)) {
            return [];
        }
    }
    return $instruction;
}

?>