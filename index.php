<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Terminal</title>
</head>
<body>
    <?php

    session_start();

    ?>

    <h1 id="titleMarks">&lt; <span id="title">Terminal</span> &gt;</h1>

    <div class="terminalContainer">
        <form name="terminal" action="projectController.php" method="post">
            <div id="formContainer">
                <span id="actualPath"><span id="dollar">$</span> terminal</span>
                <span id="index">&gt;</span>
                <input type="text" name="instructionSent" id="text" autocomplete="off" spellcheck="false" autofocus>
                <input type="submit" id="submit">
            </div>
        </form>

        <hr id="separator"></hr>

        <div id="feed">
            <div id="feedContent">
                <?php

                if (file_exists("feed.txt")) {
                    echo nl2br(file_get_contents("feed.txt"));
                }

                ?>
            </div>
        </div>
    </div>
    <div id="helpBox">
        <p><span id="help">--help</span> [lista de comandos]</p>
    </div>
</body>
</html>