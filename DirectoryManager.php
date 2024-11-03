<?php

use function PHPSTORM_META\elementType;

/**
 * Class DirectoryManager
 *
 * Esta clase proporciona funcionalidades para gestionar directorios.
 */
class DirectoryManager {

    /**
     * Crea un directorio.
     *
     * @param string $path La ruta del directorio a crear.
     * @return bool Retorna true si el directorio se crea correctamente, false en caso contrario.
     */
    public function createDirectory($path)
    {
        if (is_dir($path)) {
            return false;
        }
        return mkdir($path);
    }

    /**
     * Elimina un directorio y su contenido.
     *
     * @param string $path La ruta del directorio a eliminar.
     * @return bool Retorna true si el directorio se elimina correctamente, false en caso contrario.
     */
    public function deleteDirectory($path)
    {
        $existingElements = scandir($path);
        $elementCount = count($existingElements);

        if ($elementCount > 2) {
            return $this->deleteDirectoryRecursively($path);
        } elseif ($elementCount == 2) {
            return rmdir($path);
        } else {
            return false;
        }
    }

    /**
     * Función auxiliar para eliminar directorios de forma recursiva.
     *
     * @param string $path La ruta del directorio a eliminar.
     * @return bool Retorna true si la operacines se han realizado con éxito, falase en caso contrario.
     */
    private function deleteDirectoryRecursively($path)
    {
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == "." || $file == "..") {
                    continue;
                }

                $pathThrough = $path.DIRECTORY_SEPARATOR.$file;

                if (is_dir($pathThrough)) {
                    $this->deleteDirectoryRecursively($pathThrough);
                } else {
                    unlink($pathThrough);
                }
            }
            closedir($dh);
        }
        return rmdir($path);
    }

    /**
     * Mueve un directorio a una nueva ubicación.
     *
     * @param string $sourcePath La ruta del directorio de origen.
     * @param string $destinationPath La nueva ruta de destino.
     * @return bool Retorna true si el directorio se mueve correctamente, false en caso contrario.
     */
    public function moveDirectory($sourcePath, $destinationPath)
    {
        if (is_dir($sourcePath)) {
            return rename($sourcePath, $destinationPath);
        } else {
            return false;
        }
    }

    /**
     * Copia un directorio a una nueva ubicación.
     *
     * @param string $sourcePath La ruta del directorio de origen.
     * @param string $destinationPath La nueva ruta de destino.
     * @return bool Retorna true si el directorio se copia correctamente, false en caso contrario.
     */
    public function copyDirectory($sourcePath, $destinationPath) {
        $existingElements = scandir($sourcePath);
        $existingElements = array_diff($existingElements, ['.', '..']);
        
        if (!is_dir($destinationPath)) {
            $this->createDirectory($destinationPath);
        }
    
        foreach ($existingElements as $element) {
            $elementPath = $sourcePath.DIRECTORY_SEPARATOR.$element;
            $elementDest = $destinationPath.DIRECTORY_SEPARATOR.$element;
    
            if (is_dir($elementPath)) {
                $this->copyDirectory($elementPath, $elementDest);
            } else {
                copy($elementPath, $elementDest);
            }
        }
        return true;
    }

    /**
     * Comprueba la fecha y hora de la última modificación de la carpeta especificada
     * en la ruta.
     * 
     * @param string $path La ruta del directorio.
     * @return bool Retorna true si en cuentra el directorio, false en caso contrario.
     */
    public function getDirectoryModificationTime($path)
    {
        if (is_dir($path)) {
            $timeCapture = filemtime($path);
            return date("d-m-Y H:i:s", $timeCapture);
        } else {
            return false;
        }
    }

}
