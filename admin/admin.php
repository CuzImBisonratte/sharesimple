<?php 
    
    // Get and decode the json files
    $settings = json_decode(file_get_contents('../config/settings.json'), true);
    $allowed_file_types = json_decode(file_get_contents('../config/file_extensions.json'), true);

    // Get all settings
    $max_file_size = $settings['max_file_size'];
    $max_file_name_length = $settings['max_file_name_length'];
    $allow_all_file_types = $settings['allow_all_file_types'];
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareSimple - Admin</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/b5c383da68.js" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Close icon -->
    <div class="close-icon" onclick="closeadmin();">
        <i class="fa-solid fa-square-xmark"></i>
    </div>


    <!-- Container for outputting messages -->
    <div id="output_message">
    </div>

    <div class="container">
        <div class="tabs">
            <ul>
                <a href="#allowed_extensions">
                    <li>
                        <i class="fa-solid fa-file-circle-check"></i> Erlaubte Dateien
                    </li>
                </a>
                <a href="#dangerzone">
                    <li>
                        <i class="fa-solid fa-triangle-exclamation"></i> Dangerzone
                    </li>
                </a>
                <a href="#infos">
                    <li>
                        <i class="fa-solid fa-info-circle"></i> Weitere Infos
                    </li>
                </a>
            </ul>

        </div>
        <div class="admin">
            <div id="allowed_extensions">
                <h1>Erlaubte dateien</h1>
                <div class="admin_details">
                    <p>
                        <span>Alle Dateiendungen erlauben</span>
                        <br>
                        <br>
                        <button class="button_active">Ja</button>
                        <button class="button_inactive">Nein</button>
                    </p>
                    <p>
                        <span>Erlaubte Dateiendungen</span>
                        <br>
                        <br>
                        <?php 
                            foreach ($allowed_file_types as $key => $value) {
                                echo("<button onclick='delete_button(this);' class='button_active'>$value</button>");
                            }
                        ?>
                        <button onclick="addFileExtension()" class="button_purple">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </p>
                </div>
            </div>
            <div id="dangerzone">
                <h1>Dangerzone</h1>
                <div class="admin_details">
                    <h3>Zurücksetzen</h3>
                    <button onclick="open_pw_change();" class="warning_button">ShareSimple-Installation zurücksetzen</button>
                    <h3>ShareSimple deinstallieren</h3>
                    <button onclick="window.open('./deleteaccount/','_blank')" class="warning_button">ShareSimple vollständig deinstallieren</button>
                </div>
            </div>
            <div id="infos">
                <h1>Weitere Informationen</h1>
                <div class="admin_details">
                    <p>ShareSimple ist OpenSource und wird durch CuzImBisonratte bereitgestellt.</p>
                    <p>Bei problemen kann ein GitHub-Issue unter
                        <a href="http://github.com/sharesimple/">https://github.com/sharesimple/</a> erstellt werden.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Get the ajax library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Get all other scripts -->
    <script src="./admin.js"></script>
</body>

</html>