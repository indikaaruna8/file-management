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
 * Index controller manage all file management related actions
 *
 * @author indikaaruna
 */
include_once APPLICATION_PATH . "/model/FolderManager.php";

class IndexController extends Base {

    //put your code here

    function __construct() {
        parent::__construct();
    }
    private  $messages;
    /**
     * Index action 
     * @param type $folder
     * @return html
     */
    public function indexAction($folder = "/") {
        
        $folder= ("/"!=$folder && substr($folder, 1)!="/") ? "/" . $folder :$folder;
        $myDirectory = $this->getFolders($folder);
        
        //print_r($myDirectory);
        //echo json_encode($myDirectory);
        $data = new ViewData();

        $data->folderList = $myDirectory;
        $data->currentFolder = $folder;
        $data->messages= $this->messages;
        return $this->view->renderView(
                        VIEW_PATH . "index" . DIRECTORY_SEPARATOR . "index.php", $data
        );
    }
   
    /**
     * 
     *  get folder list
     * @return  array
     */
    public function folderAction() {
        $this->response->setIsJasonResponse(true);
        $folder = $this->request->httpGet("folder");
        $parentFolder = $this->request->httpGet("parentFolder");
        $parentFolder = substr($parentFolder, 1);
        $myDirectory = $this->getFolders($parentFolder . $folder);
        return $myDirectory;
    }
     
    /**
     * 
     * @param array $subFolder
     * @return array
     */
    public function getFolders($subFolder) {

        $topDir = $this->config->get("top_dir") . DIRECTORY_SEPARATOR . $subFolder;
        if ("" == $topDir) {
            $this->systemError->setSystemError("Parent directory not specified", TRUE, "40001");
        } else if (!file_exists($topDir)) {
            $this->systemError->setSystemError("Folder Not found", TRUE, "40002");
        } else {
            $folderManager = new FolderManager();
            return $folderManager->getFileList($topDir);
        }

        return array();
    }
    /**
     * Dosnloan Action 
     */
    public function downloadAction() {
        $topDir = $this->config->get("top_dir");
        //$this->response->setHideLayout(true);
        $fileName = $this->request->httpGet("filename");
        $parentFolder = $this->request->httpGet("parentFolder");
        $parentFolder = substr($parentFolder, 1);
        $file = $topDir . DIRECTORY_SEPARATOR . $parentFolder . $fileName;
        //$this->response->setHader($key, $value);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    /**
     * rename file Action 
     * @return array
     */
    public function renameAction() {
        $topDir = $this->config->get("top_dir");
        $newFolderName = $this->request->httpGet("file_or_folder_name");
        echo $oldFileOrFolderName = $this->request->httpGet("file_or_folder_old_name");
        $parentFolder = $this->request->httpGet("parentFolder");
        $parentFolder = substr($parentFolder, 1);
        $folderManger= new FolderManager();
        $this->response->setIsJasonResponse(true);
        return $folderManger->rename($newFolderName, $oldFileOrFolderName, $parentFolder);
    }

   /**
    *  Delete Action 
    * @return array
    */
    public function deleteAction() {
        $fileOrFolderList = $this->request->httpGet("file_or_folder_list");
        $parentFolder = $this->request->httpGet("parentFolder");
        $folderManage = new FolderManager();
        $this->response->setIsJasonResponse(true);
        return $folderManage->deleteFiels($parentFolder, $fileOrFolderList);
    }
    /**
     * create new directory 
     * @return array
     */
    public function mkdirAction() {
        $newFolderName = $this->request->httpGet("new_folder_name");
        $parentFolder = $this->request->httpGet("parentFolder");
        $parentFolder = $this->getCleanParentFolder($parentFolder);
        $folderManage = new FolderManager();
        $this->response->setIsJasonResponse(true);
        return $folderManage->createDirectory($parentFolder ,$newFolderName);
    }
    /**
     *  Upload File acton 
     * @return  hrml 
     */
    public function uploadAction() {
        $parentFolder = $this->request->httpPost("parentFolder");
        $parentFolder = $this->getCleanParentFolder($parentFolder);
        $topDir = $this->config->get("top_dir");
        $path = $topDir . DIRECTORY_SEPARATOR . $parentFolder;
        $folderManage = new FolderManager();
        $this->messages=$folderManage->uploadFile($path);
        return $this->indexAction($parentFolder);
    }

    /**
     * remvoe fisst char of string 
     * @param string $parentFolder
     * @return string
     */ 
    function getCleanParentFolder($parentFolder) {
        return substr($parentFolder, 1);
        ;
    }
    /**
     * Move folder action 
     * @return array
     */
    public function moveAction() {
        $moveTo = $this->request->httpGet("move_to");
        $parentFolder = $this->request->httpGet("parentFolder");
        $fileOrfolderForMove = $this->request->httpGet("files_or_folders_for_move");
        $folderManage = new FolderManager();
        $this->response->setIsJasonResponse(true);
        return $folderManage->moveFileAndFolder($parentFolder, $fileOrfolderForMove, $moveTo);
    }

}
