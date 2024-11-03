<?php

/**
 * Class FileManager
 *
 * Esta clase proporciona funcionalidades para gestionar archivos.
 */
class FileManager {

    /**
     * Crea un archivo.
     * 
     * @param string $filePath La ruta del archivo.
     * @return bool Retorna true si el archivo se crea correctamente, false en caso contrario.
     */
    public function createFile($filePath) 
    {
        if (touch($filePath)) {
            return true;
        }
        return false;
    }

    /**
     * Obtiene el estado de un archivo (tamaño, fecha de modificación, etc.).
     *
     * @param string $filePath La ruta del archivo.
     * @return array Retorna un array asociativo (con índices size y modified) con información del archivo o false si el archivo no existe.
     */
    public function getFileStatus($filePath) 
    {
        if (is_file($filePath)) {
            $stats = stat($filePath);
            return [
                "size" => $stats["size"],
                "modified" => $stats["modified"]
            ];
        }
        return false;
    }

    /**
     * Elimina un archivo.
     *
     * @param string $filePath La ruta del archivo a eliminar.
     * @return bool Retorna true si el archivo se elimina correctamente, false en caso contrario.
     */
    public function deleteFile($filePath)
    {
        if (is_file($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    /**
     * Mueve un archivo a una nueva ubicación.
     *
     * @param string $sourcePath La ruta del archivo de origen.
     * @param string $destinationPath La nueva ruta de destino.
     * @return bool Retorna true si el archivo se mueve correctamente, false en caso contrario.
     */
    public function moveFile($sourcePath, $destinationPath)
    {
        if (is_file($sourcePath) && !is_file($destinationPath)) {
            return rename($sourcePath, $destinationPath);;
        }
        return false;
    }

    /**
     * Copia un archivo a una nueva ubicación.
     *
     * @param string $sourcePath La ruta del archivo de origen.
     * @param string $destinationPath La nueva ruta de destino.
     * @return bool Retorna true si el archivo se copia correctamente, false en caso contrario.
     */
    public function copyFile($sourcePath, $destinationPath)
    {
        if (is_file($sourcePath) && !is_file($destinationPath)) {
            return copy($sourcePath, $destinationPath);;
        }
        return false;
    }

    /**
     * Busca un archivo dentro del sistema.
     *
     * @param string $filePath La ruta completa del archivo a buscar.
     * @return bool Retorna true si el archivo existe, false en caso contrario.
     */
    public function searchFile($filePath)
    {
        if (is_file($filePath)) {
            return true;
        }
        return false;
    }

    /**
     * Sobreescribre el contenido de un fichero.
     *
     * @param string $filePath La ruta del archivo.
     * @param string $content El contenido a insertar en el archivo.
     * @return bool Retorna true si se ha creado el fichero o se ha leído con éxito, false en ambos casos contrarios.
     */
    public function saveFile($filePath, $content)
    {
        return $this->writeToFile($filePath, $content, "w+");
    }

    /**
     * Modifica el contenido de un fichero añadiendo una nueva línea.
     *
     * @param string $filePath La ruta del archivo.
     * @param string $content El contenido a insertar en el archivo.
     * @return bool Retorna true si se ha creado el fichero o se ha leído con éxito, false en ambos casos contrarios.
     */
    public function saveFileAddLine($filePath, $content)
    {
        if (!is_file($filePath)) {
            return $this->writeToFile($filePath, $content, "a+"); 
        }
        return $this->writeToFile($filePath, PHP_EOL.$content, "a+");        
    }

    /**
     * Comprueba si el fichero existe o no. Si no existe lo crea y dependiendo de si se ha especificado
     * contenido por parámetro, se le añade contenido o no. Si se ha especificado contenido, se abre
     * el fichero y se procede a escribir en él.
     * 
     * @param string $filePath La ruta del archivo.
     * @param string $content El contenido a insertar en el archivo.
     * @param string $mode El modo de apertura del fichero (w+/a+.)
     * @return bool Retorna true si se ha creado el fichero o se ha leído con éxito, false en ambos casos contrarios.
     */
    private function writeToFile($filePath, $content, $mode)
    {
        if (!is_file($filePath)) {
            $this->createFile($filePath);
            if (empty($content)) return true;
        }

        if ($file = fopen($filePath, $mode)) {

            fwrite($file, $content);
            fclose($file);

            return true;
        }
        return false;
    }

    /**
     * Comprueba los permisos de un archivo
     * 
     * @param string $filePath La ruta del archivo.
     * @return array Retorna una array asociativo (con índices redable, writable y executable) con información sobre
     * los permisos del archivo.
     */
    public function filePermissions($filePath)
    {
        if (is_file($filePath)) {
            return [
                "readable" => is_readable($filePath),
                "writable" => is_writable($filePath),
                "executable" => is_executable($filePath)
            ];
        }
    }
}