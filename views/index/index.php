<div class="folder-info">
    <fieldset>
        <legend >
            <span id="root-folder"><?php echo $this->data->currentFolder ?></span>
            <input type="button" id="input_up_level" value="UP"  >
        </legend>
        <div>

            <div >
                <table>
                    <tr>
                        <td>
                            <table id="folder-list">
                                <thead>
                                    <tr>
                                        <th class="folder-select"></th>
                                        <th class="folder-type"></th>

                                        <th class="folder-name">Name</th>
                                        <th class="folder-size">Size </th>
                                        <th class="folder-action">Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->data->folderList as $fileOrFolderInfo) { ?>
                                        <tr folder-name="<?php echo $fileOrFolderInfo["name"] ?>">
                                            <td><input type="checkbox"/></td>
                                            <td><?php
                                                if ("dir" == $fileOrFolderInfo["type"]) {
                                                    echo $fileOrFolderInfo["type"];
                                                }
                                                ?></td>

                                            <td>
                                                <?php if ("dir" == $fileOrFolderInfo["type"]) { ?>
                                                    <a href="#" data-folder="<?php echo $fileOrFolderInfo["name"] ?>" class="folder-link"><?php echo $fileOrFolderInfo["name"] ?></a>
                                                <?php } else { ?> 
                                                    <?php echo $fileOrFolderInfo["name"] ?>
                                                <?php } ?>
                                            </td>
                                            <td class="folder-size"><?php echo $fileOrFolderInfo["size"] ?></td>
                                            <td>
                                                <span class="button-panel" >

                                                    <input type="button" class="input_move" value="MOVE"  >
                                                    <input type="button" class="input_ren" value="REN"  >
                                                    <input type="button" class="input_del" value="DEL"  >
                                                    <?php if ("dir" != $fileOrFolderInfo["type"]) { ?>
                                                        <input type="button" class="input_download" value="DOWNLOAD"  >
                                                    <?php } ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <?php if (1 == 2) { ?>
                                <div>
                                    <ul>
                                        <?php foreach ($this->data->folderList as $fileOrFolderInfo) { ?>

                                            <?php if ("dir" == $fileOrFolderInfo["type"]) { ?>
                                                <li data="<?php echo $fileOrFolderInfo["name"] ?>"> 
                                                    <a href="#" parent-folder="/" data-folder="<?php echo $fileOrFolderInfo["name"] ?>" class="folder-link hasparent"> <?php echo $fileOrFolderInfo["name"] ?></a>
                                                </li>
                                            <?php } ?>


                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div >
    </fieldset>
    <fieldset class="form-fotter">
        <input type="button" id="input-dell-all" value="Dell All">
        <input type="button" id="input-move-all" value="Move All">
        <input type="button" id="input-upload" value="Upload">
        <input type="button" class="input-mkdir" value="Mkdir">

        <div>

        </div>
    </fieldset>
    <fieldset class="form-message info">
        <?php
        $waintingTime=0;
        if (count($this->data->messages) > 0) {
            foreach ($this->data->messages as $mess) {
                 $waintingTime=8500;
                ?>

                <p class="<?php
                if ($mess["success"]) {
                    echo "success";
                } else
                    echo "fail";
                ?>"><?php echo $mess["message"]; ?></p>

        <?php
    }
    ?>
            
    <?php
}
?>
                <script>
                $(document).ready(function () {
                    setTimeout(function () {
                        $(".form-message").removeClass("info", 500);
                    }, <?php echo $waintingTime?>);
                });
            </script>
    </fieldset>
</div>
<div id="grid-button-panel" class="hide">
    <span class="button-panel">
        <input type="button" class="input_move" value="MOVE"  >
        <input type="button" class="input_ren" value="REN"  >
        <input type="button" class="input_del" value="DEL"  >

        <input type="button" class="input_download" value="DOWNLOAD"  >
    </span>
</div>
<div id="rename-dialog-form" title="Rename File Or Folder">
    <p class="validateTips">All form fields are required.</p>

    <form id="rename-form">
        <fieldset>
            <label for="name">New Name</label>
            <input type="text" name="rename_from_name" id="rename-form-name" value="" class="text ui-widget-content ui-corner-all">
            <input type="hidden" name="rename_from_old_name" id="rename-form-old-name" value="" class="text ui-widget-content ui-corner-all">     

            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>
<div id="new-folder-form" title="Create Folder">
    <p class="validateTips">All form fields are required.</p>

    <form id="new-folder-form1">
        <fieldset>
            <label for="name">Folder Name</label>
            <input type="text" name="new-folder-form_name" id="new-folder-form_name" value="" class="text ui-widget-content ui-corner-all">

            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>
<div id="upload-file" title="Upload File">
    <form id="upload-file_form" method="post" enctype="multipart/form-data" action="/<?php echo URL_ALLIAS ?>/index/upload">
        <fieldset>

            <label for="name">File </label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <p>
                <input type="hidden" name="parentFolder" id="upload-file-parent-folder">
                <input type="submit" value="submit" />
            </p>
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>

<div id="download-dialog" title="FIle Download">
    <p class="validateTips">Downloading....</p>
</div>
<div id="folder-list-for-select">
    <fieldset>
        <legend><span id="popup-root">/</span><input type="button" value="UP" id="input_folder_up_level"></legend>
        <table id="folder-list-in-pop-up">
            <tr>
                <td></td>
            </tr>
        </table>
    </fieldset>  
</div>
