<?php

    const GREY1 = "<span id='separatorHelp'>";
    const GREY2 = "</span>";

    const GREEN1 = "<span id='command'>";
    const GREEN2 = "</span>";

    const RED1 = "<span id='helpImportant'>";
    const RED2 = "</span>";

    const TITLE1 = "<span id='listComandTitle'>";
    const TITLE2 = "</span>";

    /**
     * Permite almacenar la información de cada comando de forma individual en un array.
     * 
     * @return array $helpContent Array completo con cada uno de los comandos.
     */
    function helpCommandsIndividual() {
        $l = "<br>";
        $l2 = "<br><br>";
        $separator1 = GREY1."----------------".GREY2.$l2;
        $separator = GREY1."-------------------------------".GREY2.$l2;

        $helpContent = [
            "mkdir" => " -> [".GREEN1."mkdir".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Permite crear una carpeta en la ruta indicada. (El final de la ruta será el nombre de la carpeta)$l
                Este comando únicamente funcionará si la carpeta indicada no existe en dicha ruta.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - mkdir [ruta]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [ruta] -> Ruta donde crear la carpeta.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - mkdir nuevaCarpeta$l
                - mkdir nuevaCarpeta/subcarpeta
                ",
            "touch" => " -> [".GREEN1."touch".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Permite crear un archivo vacío en la ruta indicada. (El final de la ruta será el nombre del archivo)$l
                Este comando únicamente funcionará si el archivo indicado no existe en dicha ruta.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - touch [ruta]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [ruta] -> Ruta del archivo a crear.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - touch nuevoArchivo.txt$l
                - touch carpeta/nuevoArchivo.txt
                ",
            "modtime" => " -> [".GREEN1."modtime".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra la fecha y hora de la última modificación únicamente de una carpeta.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - modtime [ruta]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [ruta] -> Ruta de la carpeta.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - modtime archivo.txt$l
                - modtime carpeta/archivo.txt
                ",
            "stats" => " -> [".GREEN1."stats".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra estadísticas únicamente del archivo seleccionado.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - stats [ruta]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [ruta] -> Ruta del archivo.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - stats archivo.txt$l
                - stats carpeta/archivo.txt
                ",
            "find" => " -> [".GREEN1."find".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Busca únicamente archivos que coincidan con el nombre indicado.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - find [archivo]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [archivo] -> Nombre del archivo a buscar.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - find archivo.txt
                - find estilo.php
                ",
            "permfile" => " -> [".GREEN1."permfile".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra únicamente los permisos de un archivo.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - permfile [ruta]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [ruta] -> Ruta del archivo.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - permfile archivo.txt$l
                - permfile carpeta/archivo.txt
                ",
            "ls" => " -> [".GREEN1."ls".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra un listado de las rutas comunes del sistema.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - ls$l2
                ",
            "pwd" => " -> [".GREEN1."pwd".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra la ruta de la carpeta de trabajo del proyecto.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - pwd$l2
                ",
            "df" => " -> [".GREEN1."df".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra información sobre el espacio en disco utilizado y disponible del sistema.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - df$l2
                ",
            "osinfo" => " -> [".GREEN1."osinfo".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Muestra información sobre el sistema operativo actual.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - osinfo$l2
                ",
            "rm" => " -> [".GREEN1."rm".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Permite eliminar un archivo o carpeta (".RED1."¡CUIDADO!".RED2." también de forma recursiva).$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - rm [-f/-d] [ruta]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [-d] -> Indica que se desea eliminar una carpeta.$l2
                - [-f] -> Indica que se desea eliminar un archivo.$l2
                - [ruta] -> Ruta del archivo o carpeta a eliminar.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - rm -f archivo.txt$l
                - rm -d nuevaCarpeta$l
                - rm -f carpetaVieja/archivoAntiguo.txt
                ",
            "cp" => " -> [".GREEN1."cp".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Permite copiar un archivo o carpeta.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - cp [-f/-d] [ruta] [rutaDestino]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [-d] -> Indica que se desea copiar una carpeta.$l2
                - [-f] -> Indica que se desea copiar un archivo.$l2
                - [ruta] -> Ruta del archivo o carpeta a copiar.$l2
                - [rutaDestino] -> Ruta donde se desea copiar.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - cp -f archivo.txt nuevaRuta/copiaArchivo.txt$l
                - cp -d carpeta/carpetaACopiar nuevaRuta/copiaCarpeta$l
                ",
            "mv" => " -> [".GREEN1."mv".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Permite mover o renombrar un archivo o carpeta.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - mv [-f/-d] [ruta] [rutaDestino]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [-d] -> Indica que se desea mover/renombrar una carpeta.$l2
                - [-f] -> Indica que se desea mover/renombrar un archivo.$l2
                - [ruta] -> Ruta del archivo o carpeta a mover/renombrar.$l2
                - [rutaDestino] -> Ruta donde se desea mover.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - mv -f carpeta/archivo.txt nuevaRuta/archivoMovido.txt [Mover]$l
                - mv -d carpeta/carpeta1 carpeta/carpeta1Renombrada [Renombrar]$l
                ",
            "vim" => " -> [".GREEN1."vim".GREEN2."] <- $l2
                $separator1
                ".GREEN1."Descripción".GREEN2.":$l2
                Permite editar un archivo en el editor Vim. Se puede editar sobreescribiendo el contenido
                o añadiendo una nueva línea. Si no se especifica ningún contenido, simplemente se creará el
                archivo en caso de que este no exista con anterioridad.$l2
                $separator
                ".GREEN1."Sintaxis".GREEN2.":$l2
                - vim [ruta]$l2
                - vim [ruta] [contenido]$l2
                - vim [-a] [ruta] [contenido]$l2
                $separator
                ".GREEN1."Parámetros".GREEN2.":$l2
                - [ruta] -> Ruta del archivo a editar/crear.$l2
                - [contenido] -> Contenido a añadir o sobreescribir (No es necesario introducirlo entre comillas,
                se permiten espacios en el parámetro).$l2
                - [-a] -> Añade contenido en una nueva línea sin sobrescribir el contenido del archivo.$l2
                $separator
                ".GREEN1."Ejemplos de uso".GREEN2.":$l2
                - vim archivo.txt$l
                - vim archivo.txt Texto nuevo con espacios $l
                - vim -a archivo.txt Texto adicional con espacios $l
                "
        ];
        return $helpContent;
    }

    /**
     * Permite almacenar una lista general de los comandos que existen.
     * 
     * @return string La lista completa de comandos.
     */
    function helpCommands() {
        $l = "<br>";
        $l2 = "<br><br>";
        $separator = GREY1."-------------------------------".GREY2.$l2;

        return TITLE1."[".GREEN1."Lista de comandos".GREEN2."]".TITLE2."$l2
            $separator
            CONSULTA CADA COMANDO DE FORMA MÁS DETALLADA USANDO ".GREEN1."--help".GREEN2." [comando]$l
            Ejemplo: --help mkdir$l2
            $separator
            ".TITLE1."*Comandos sobre carpetas*".TITLE2."$l2
            - ".GREEN1."mkdir".GREEN2." -> Crea carpetas.$l
            - ".GREEN1."modtime".GREEN2." -> Consulta última modificación de carpetas.$l
            - ".GREEN1."rm".GREEN2." -> Elimina carpetas. [".RED1."¡IMPORTANTE!".RED2." Revisar documentación antes de usar]$l
            - ".GREEN1."cp".GREEN2." -> Copia carpetas.$l
            - ".GREEN1."mv".GREEN2." -> Mueve carpetas.$l2
            $separator
            ".TITLE1."*Comandos sobre archivos*".TITLE2."$l2
            - ".GREEN1."touch".GREEN2." -> Crea archivos.$l
            - ".GREEN1."find".GREEN2." -> Busca archivos.$l
            - ".GREEN1."stats".GREEN2." -> Consulta estadísticas de archivos.$l
            - ".GREEN1."permfile".GREEN2." -> Consulta permisos de archivos.$l
            - ".GREEN1."vim".GREEN2." -> Crea o modifica contenido de archivos.$l2
            - ".GREEN1."rm".GREEN2." -> Elimina archivos.$l
            - ".GREEN1."cp".GREEN2." -> Copia archivos.$l
            - ".GREEN1."mv".GREEN2." -> Mueve archivos.$l2
            $separator
            ".TITLE1."*Comandos sobre sistema*".TITLE2."$l2
            - ".GREEN1."ls".GREEN2." -> Consulta rutas comunes del sistema.$l
            - ".GREEN1."pwd".GREEN2." -> Consulta la ruta raíz del sistema.$l
            - ".GREEN1."df".GREEN2." -> Consulta la memoria del sistema.$l
            - ".GREEN1."osinfo".GREEN2." -> Consulta el información del sistema/dispositivo que se está usando.$l2";
    }

?>