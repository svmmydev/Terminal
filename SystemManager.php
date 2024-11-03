<?php

/**
 * Class SystemManager
 *
 * Esta clase proporciona funcionalidades generales para gestionar el sistema de archivos.
 */
class SystemManager
{
    /**
     * Lista las rutas del sistema de archivos.
     * Devuelve una lista de rutas comunes o directorios que se pueden encontrar en el sistema.
     *
     * @return array Retorna un array con las rutas disponibles en el sistema.
     */
    public function listSystemPaths() {
        $directoryIterator = ["terminalDirectory"];
        $rutes = ["/"];
    
        while (!empty($directoryIterator)) {
            $path = array_pop($directoryIterator);
            $directories = scandir($path);
    
            foreach ($directories as $dir) {
                if ($dir !== "." && $dir !== "..") {
                    $fullPath = $path."/".$dir;
    
                    if (is_dir($fullPath)) {
                        $rutes[$dir] = $fullPath;
                        $directoryIterator[] = $fullPath;
                    }
                }
            }
        }
        ksort($rutes);
        return $rutes;
    }

    /**
     * Obtiene el estado del sistema de archivos (espacio libre, espacio total y espacio utilizado).
     *
     * @param string $path La ruta del sistema de archivos de la que se desea obtener el estado.
     * @return array|false Retorna un array con las claves 'total_space', 'free_space' y 'used_space', o false si el directorio no es válido.
     */
    public function getSystemStatus($path = '/')
    {
        if (is_dir($path)) {
            $freeSpace = disk_free_space($path);
            $totalSpace = disk_total_space($path);
            $usedSpace = $totalSpace - $freeSpace;
    
            $diskSpace = [
                "total_space" => $totalSpace,
                "used_space" => $usedSpace,
                "free_space" => $freeSpace
            ];
    
            return $diskSpace;
        } else {
            return false;
        }
    }

    /**
     * Obtiene la ruta actual del sistema donde se está ejecutando el programa.
     *
     * @return string Retorna la ruta del directorio actual de trabajo.
     */
    public function getSystemPath()
    {
        return getcwd().DIRECTORY_SEPARATOR."terminalDirectory";
    }

    /**
    * Obtiene información sobre el sistema operativo.
    *
    * @return string Información del sistema operativo.
    */
    public function getOSInfo()
    {
        return php_uname();
    }
}
