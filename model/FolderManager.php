<?php

/*
 *   _$$$$$__ _$$__ _______ _______ ______ _______ _$$__ _______
 *   $$___$$_ _$$__ $$__$$_ $$$$$__ ______ $$$$$__ _$$__ $$$$$__
 *   _$$$____ _____ $$__$$_ ____$$_ $$_$$_ ____$$_ $$$$_ ____$$_
 *   ___$$$__ _$$__ _$$$$$_ _$$$$$_ $$$_$_ _$$$$$_ _$$__ _$$$$$_
 *   $$___$$_ _$$__ ____$$_ $$__$$_ $$____ $$__$$_ _$$__ $$__$$_
 *   _$$$$$__ $$$$_ $$$$$__ _$$$$$_ $$____ _$$$$$_ __$$_ _$$$$$_ 
 */
 
/**
 * This is the model for for Folder and file manage. 
 * 
 * @author indikaaruna
 */
class FolderManager extends Base {

    private $topDir;
    private $logFile;

    /**
     * Constructor 
     */
    function __construct() {
        parent::__construct();
        $this->topDir = $this->config->get("top_dir");
        $this->logFile = $this->config->get("log_file");
    }

    /**
     * 
     * @param string $dir
     * @param string $type   3 options all,folder,file
     * @return string
     */
    function getFileList($dir, $type = "all") {
        //folders 
        $folder = array();
        // filses
        $files = array();
        // array to hold return value 
        $retval = array();
        // add trailing slash if missing 
        if (substr($dir, -1) != "/")
            $dir .= "/";
        $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");

        while (false !== ($entry = $d->read())) {
            if ($entry[0] == ".")
                continue;
            if (is_dir("$dir$entry")) {
                $folder[] = array(
                    "name" => "$entry",
                    "type" => filetype("$dir$entry"),
                    "size" => "",
                    "lastmod" => filemtime("$dir$entry")
                );
            } elseif (is_readable("$dir$entry")) {
                $files[] = array(
                    "name" => "$entry",
                    "type" => "", //mime_content_type("$dir$entry"),
                    "size" => filesize("$dir$entry") . "B",
                    "lastmod" => filemtime("$dir$entry"));
            }
        }
        $d->close();
        if ($type == "folder")
            return $folder;
        if ($type == "files")
            return $files;
        $retval = array_merge($folder, $files);

        return $retval;
    }

    /**
     * upload files
     * @param string $targetDir full path of the target directory
     * @return boolean
     */
    function uploadFile($targetDir) {
        $message = array();
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $message[] = array(
                "success" => true,
                "message" => "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded."
            );
            $this->writeLog("upload " . $targetFile);
        } else {
            $message[] = array(
                "success" => true,
                "message" => "Sorry, there was an error uploading your file."
            );
        }
        return $message;
    }

    /**
     * Move files
     * @param string $parentFolder  Current Parent folder of the foele
     * @param array $fileOrfolderForMove  file or folder for move
     * @param string  $moveTo Parent forlder for move to
     * @return array   
     */
    public function moveFileAndFolder($parentFolder, $fileOrfolderForMove, $moveTo) {
        $messages = array();
        $moToPhysicleMap = $moveTo . DIRECTORY_SEPARATOR;
        $moveToPhysicle = $this->topDir . $moToPhysicleMap;
        $fileExistPhsycle = $this->topDir . $parentFolder;
        //exit("xx");
        if (file_exists($moveToPhysicle)) {
            for ($i = 0; $i < count($fileOrfolderForMove); $i++) {

                $moveFile = $fileExistPhsycle . $fileOrfolderForMove[$i];
                if (file_exists($moveFile)) {
                    $moveToLocation = $moveToPhysicle . $fileOrfolderForMove[$i];
                    $success = rename($moveFile, $moveToLocation);
                    $messages[] = array(
                        "fileOrFolder" => $fileOrfolderForMove[$i],
                        "success" => $success,
                        "message" => (false == $success) ? "Moving Fail .Please check permission." : "Successfully  moved. "
                    );
                    if ($success)
                        $this->writeLog("Move from  " . $moveFile . " to " . $moveToLocation);
                } else {
                    $messages[] = array(
                        "fileOrFolder" => $fileOrfolderForMove[$i],
                        "success" => false,
                        "message" => "File or folder not exists"
                    );
                }
            }
        } else {
            //$this->systemError->setSystemError($moToPhysicleMap . " not found.", TRUE, "60001");
            $messages[] = array(
                "fileOrFolder" => $fileOrfolderForMove[$i],
                "success" => false,
                "message" => "Folder not  not exists."
            );
        }
        return $messages;
    }

    /**
     * 
     * @param string $parentFolder File or folder containing folder
     * @param array $foldrList   folder or file list for delete 
     * @return array
     */
    function deleteFiels($parentFolder, $foldrList) {

        $messages = array();
        $parentFolder = substr($parentFolder, 1);
        for ($i = 0; $i < count($foldrList); $i++) {
            //echo $foldrList[$i];
            $path = $this->topDir . DIRECTORY_SEPARATOR . $parentFolder . $foldrList[$i];

            if (file_exists($path)) {
                if (is_dir($path)) {
                    $success = rmdir($path);
                } else {
                    $success = unlink($path);
                }
                if ($success)
                    $this->writeLog("Deleted  " . $path);
                $messages[] = array(
                    "fileOrFolder" => $foldrList[$i],
                    "success" => $success,
                    "message" => (false == $success) ? "Deleting Fail .Please check permission." : "Successfully  deleted. "
                );
            } else {
                $messages[] = array(
                    "fileOrFolder" => $foldrList[$i],
                    "success" => false,
                    "message" => "Folder not  not exists."
                );
            }
        }
        //exit();
        return $messages;
    }

    /**
     * 
     * @param string $parentFolder Parent folder which have to create new folder
     * @param string $newFolderName   new folder name
     * @return arrray
     */
    function createDirectory($parentFolder, $newFolderName) {

        $messages = array();
        $path = $this->topDir . DIRECTORY_SEPARATOR . $parentFolder . $newFolderName;
        $success = false;
        if (file_exists($path)) {
            $messages[] = array(
                "fileOrFolder" => $newFolderName,
                "success" => false,
                "message" => "Folder already exists."
            );
        } else {
            if (file_exists($this->topDir . DIRECTORY_SEPARATOR . $parentFolder)) {
                $succses = mkdir($path);
                if (!$succses) {
                    $messages[] = array(
                        "fileOrFolder" => $parentFolder,
                        "success" => false,
                        "message" => "Unkown error.Plaase Check permission.≈"
                    );
                } else {
                    $this->writeLog("created  " . $path);
                }
            } else {
                $messages[] = array(
                    "fileOrFolder" => $parentFolder,
                    "success" => false,
                    "message" => "Folder already  not exists."
                );
            }
        }
        return array(
            "success" => $succses,
            "messages" => $messages
        );
    }

    /**
     * 
     * @param type $newFolderName new file or folder name
     * @param type $oldFolderName old file or folder name
     * @param type $parentFolder  file or folder cotaining folder
     * @return array
     */
    function rename($newFolderName, $oldFolderName, $parentFolder) {
        $messages = array();
        $success = false;
        $oldName = $this->topDir . DIRECTORY_SEPARATOR . $parentFolder . $oldFolderName;
        $newName = $this->topDir . DIRECTORY_SEPARATOR . $parentFolder . $newFolderName;
        if (file_exists($newName)) {
            $messages[] = array(
                "fileOrFolder" => $newFolderName,
                "success" => false,
                "message" => "There is a other folder or file name with same name. "
            );
        } else if (file_exists($oldName)) {

            $succses = rename($oldName, $newName);
            if (!$succses) {
                $messages[] = array(
                    "fileOrFolder" => "Unknown Error",
                    "success" => false,
                    "message" => "Please check permission."
                );
            } else {
                $this->writeLog("Rename  file " . $oldName . " to " . $newName);
            }
        } else {
            $messages[] = array(
                "fileOrFolder" => $oldFolderNam,
                "success" => false,
                "message" => "Folder not exists.  "
            );
        }
        return array(
            "success" => $succses,
            "messages" => $messages
        );
    }

    /**
     * Log imprtan file transactions
     * @param string $log
     */
    function writeLog($log) {
        $log = "User: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . "\t" . $log . PHP_EOL .
                "-------------------------" . PHP_EOL;
        file_put_contents($this->logFile, $log, FILE_APPEND);
    }

}
