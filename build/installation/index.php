<!DOCTYPE html>
<!--
/*
 *   _$$$$$__ _$$__ _______ _______ ______ _______ _$$__ _______
 *   $$___$$_ _$$__ $$__$$_ $$$$$__ ______ $$$$$__ _$$__ $$$$$__
 *   _$$$____ _____ $$__$$_ ____$$_ $$_$$_ ____$$_ $$$$_ ____$$_
 *   ___$$$__ _$$__ _$$$$$_ _$$$$$_ $$$_$_ _$$$$$_ _$$__ _$$$$$_
 *   $$___$$_ _$$__ ____$$_ $$__$$_ $$____ $$__$$_ _$$__ $$__$$_
 *   _$$$$$__ $$$$_ $$$$$__ _$$$$$_ $$____ _$$$$$_ __$$_ _$$$$$_ 
 * 
 * 
 */
-->
<html>
    <head>
        <title>TOD</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../resources/js/jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
        <link href="../resources/css/main.css" rel="stylesheet" type="text/css"/>
    </head>
</head>
<body>
    <div id="container">
        <fieldset>
            <legend>Initial Setting </legend>
            <div class="form-row">
                <label class="form-label">Username:</label>
                <input type="text" class="textfield" size="24" value=""  >
            </div>
            <div class="form-row">
                <label class="form-label" >Password:</label>
                <input type="password" class="textfield" size="24" value="" >
            </div>   
        </fieldset>
        <fieldset class="form-fotter">
            <input type="submit" id="input_go" value="Go">
            <input type="hidden" value="index.php" name="target">
        </fieldset>
    </div>
</body>
</html>
