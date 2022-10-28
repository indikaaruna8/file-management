$(document).ready(function () {
    var reNameDialog, form, newFolderdialog, uploadFileDialog,
            folderNameRegx = /^[\w.-]+$/,
            rename_form_name = $("#rename-form-name"),
            rename_from_old_name = $("#rename-form-old-name"),
            allFields = $([]).add(rename_form_name).add(rename_from_old_name),
            renameTips = $("#rename-dialog-form .validateTips"),
            newFolderTips = $("#new-folder-form .validateTips"),
            new_folder_name = $("#new-folder-form_name");


    function checkRegexp(o, regexp, n, tip) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            updateTips(n, tip);

            return false;
        } else {
            return true;
        }
    }
    function updateTips(t, tip) {
        tip.text(t)
                .addClass("ui-state-highlight");
        setTimeout(function () {
            tip.removeClass("ui-state-highlight", 1500);
        }, 5500);
    }
    var successMessages = function (message) {
        $(".form-message").removeClass("fail");
        $(".form-message").addClass("success");
        $(".form-message").append($("<p />").html(message));
        setTimeout(function () {
            $(".form-message").removeClass("success", 2500);
        }, 5500);
    }
    var errorMessages = function (message) {
        $(".form-message").removeClass("success");
        $(".form-message").addClass("fail");
        if ("string" == typeof (message)) {
            $(".form-message").append($("<p />").html(message));
        } else {
            for (var i = 0; i < message.length; i++) {
                $(".form-message").append($("<p />").html(message[i].message));
            }
        }
        setTimeout(function () {
            $(".form-message").removeClass("fail", 2500);
        }, 500);
    }
    var infoMessages = function (messages) {
        for (var i = 0; i < messages.length; i++) {
            var cssClass = "";
            cssClass = (true == messages[i].success) ? "success" : "fail";
            var str = messages[i].fileOrFolder + "\t:" + messages[i].message
            $(".form-message").append($("<p  />", {class: cssClass}).html(str));
        }
        $(".form-message").addClass("info");
        setTimeout(function () {
            $(".form-message").removeClass("info", 500);
        }, 8500);
    }
    var renameFileOrFolder = function () {
        var valid = true;
        allFields.removeClass("ui-state-error");
        var parentFolder = $("#root-folder").html();
        valid = valid && checkRegexp(rename_form_name, folderNameRegx, "Invalided Characters in file name", checkRegexp, renameTips);
        if (valid) {
            $.ajax({
                type: "GET",
                url: siteUrl + "index/rename",
                data: {file_or_folder_name: rename_form_name.val(), file_or_folder_old_name: rename_from_old_name.val(), parentFolder: parentFolder}
            }).done(function (msg) {
                $(".form-message").html("");
                var dataObject = jQuery.parseJSON(msg);
                if (dataObject.errorCount == 0) {
                    if (dataObject.data.success) {

                        successMessages("Transaction successfull");
                        displayFolder(parentFolder, "");

                    } else {
                        infoMessages(dataObject.data.messages);
                    }
                } else {
                    errorMessages(dataObject.errors);
                }
                reNameDialog.dialog("close");
            });
        }
    }
    var createFolder = function () {
        var valid = true;
        var parentFolder = $("#root-folder").html();
        valid = valid && checkRegexp(new_folder_name, folderNameRegx, "Invalided Characters in file name", newFolderTips);
        if (valid) {
            $.ajax({
                type: "GET",
                url: siteUrl + "index/mkdir",
                data: {parentFolder: parentFolder, new_folder_name: new_folder_name.val()}
            }).done(function (msg) {
                $(".form-message").html("");
                var dataObject = jQuery.parseJSON(msg);
                if (dataObject.errorCount == 0) {
                    if (dataObject.data.success) {
                        successMessages("Transaction successfull");
                        displayFolder(parentFolder, "");
                    } else {
                        infoMessages(dataObject.data.messages)
                        //errorMessages("Unknown error.Please check permission")
                    }
                } else {
                    errorMessages(dataObject.errors);
                }
                newFolderdialog.dialog("close");
            });
        }
    }
    var download_dialog = $("#download-dialog").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        close: function () {
            allFields.removeClass("ui-state-error");
        }
    });
    var folderSelectDialog = $("#folder-list-for-select").dialog({
        autoOpen: false,
        height: 433,
        width: 480,
        modal: true,
        buttons: {
            Cancel: function () {
                renameTips.text("");
                folderSelectDialog.dialog("close");
                $("#folder-list input:checkbox").prop('checked', false);
            }
        },
        close: function () {


        }
    });
    reNameDialog = $("#rename-dialog-form").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Rename": renameFileOrFolder,
            Cancel: function () {
                renameTips.text("");
                reNameDialog.dialog("close");
            }
        },
        close: function () {

            $("#rename-form")[0].reset();
            allFields.removeClass("ui-state-error");

            renameTips.text("");
        }
    });
    uploadFileDialog = $("#upload-file").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            Cancel: function () {

                uploadFileDialog.dialog("close");
            }
        },
        close: function () {

        }
    });
    newFolderdialog = $("#new-folder-form").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Create": createFolder,
            Cancel: function () {
                newFolderTips.text("");
                newFolderdialog.dialog("close");
            }
        },
        close: function () {
            // $("#new-folder-form1")[0].reset();
            //$("#new-folder-form1")[0].find('input').removeClass("ui-state-error");
            $("#new-folder-form1 input").val("");
            newFolderTips.text("");
        }
    });
    $(".input-mkdir").bind("click", function () {
        newFolderdialog.dialog("open");

    });
    $("#input-upload").click(function () {
        uploadFileDialog.dialog("open");
        var parentFolder = $("#root-folder").html();
        $("#upload-file-parent-folder").val(parentFolder);
    });
    var handleDeleteFiels = function () {
            var parentFolder = $("#root-folder").html();
            var folderOrFileList = getSelectedFolderList(false);
            //console.log(folderOrFileList);
            //var fileOrFolderName=folderOrFileList[0];
            $.ajax({
                type: "GET",
                url: siteUrl + "index/delete",
                data: {file_or_folder_list: folderOrFileList, parentFolder: parentFolder}
            }).done(function (msg) {
                $(".form-message").html("");
                var dataObject = jQuery.parseJSON(msg);
                if (dataObject.errorCount == 0) {
                    infoMessages(dataObject.data);
                    displayFolder(parentFolder, "");
                } else {
                    errorMessages(dataObject.errors);
                }
                reNameDialog.dialog("close");
            });
        }
    var bindDialog = function () {
        $(".input_ren").bind("click", function () {

            reNameDialog.dialog("open");
            var fileOrFolderName = $(this).parent().parent().parent().attr("folder-name");
            $("#rename-form-name").val(fileOrFolderName);
            $("#rename-form-old-name").val(fileOrFolderName);
        });
        $(".input_download").bind("click", function () {
            $("#download-dialog").find('iframe').remove();
            download_dialog.dialog("open");
            var url = siteUrl + "index/download?filename=" + $(this).parent().parent().parent().attr("folder-name") + "&parentFolder=" + $("#root-folder").html()
            $("#download-dialog").append($('<iframe src="' + url + '" />').load(function () {
                download_dialog.dialog("close");
            }));

        });
    
        $(".input_del").bind("click", function () {
            $("#folder-list input:checkbox").prop('checked', false);
            if (confirm("Please confirm do you need to delete this file? ")) {
                $(this).parent().parent().parent().find("input:checkbox").prop('checked', true);
                handleDeleteFiels();
            }
        });
        $(".input_move").bind("click", function () {
            $("#folder-list input:checkbox").prop('checked', false);
            folderSelectDialog.dialog("open");
            $(this).parent().parent().parent().find("input:checkbox").prop('checked', true)
            displayFolderPopup("/", "");
        });
    }
    var displayFolder = function (parentFolder, folder) {
        $.ajax({
            type: "GET",
            url: siteUrl + "index/folder",
            data: {folder: folder, parentFolder: parentFolder}
        }).done(function (msg) {

            $("#folder-list").find("tr:gt(0)").remove();
            var dataObject = jQuery.parseJSON(msg);
            if (dataObject.errorCount == 0) {
                var folderList = dataObject.data;
                if (folderList.length > 0) {
                    for (var i = 0; i < folderList.length; i++) {
                        var $_tr = $(document.createElement('tr')).attr("folder-name", folderList[i].name);
                        $('<input />', {
                            type: 'checkbox',
                            name: 'test',
                        }).appendTo($('<td>').appendTo($_tr));
                        $('<td />').html(folderList[i].type).appendTo($_tr);
                        var buttonPanel = $("#grid-button-panel .button-panel").clone();
                        if ("dir" == folderList[i].type) {
                            $('<a />', {
                                "data-Folder": folderList[i].name,
                                class: "folder-link",
                                href: "#"
                            }).html(folderList[i].name).appendTo($('<td />').appendTo($_tr));

                            buttonPanel.find(".input_download").remove();
                        } else {
                            $('<td />').html(folderList[i].name).appendTo($_tr);
                        }
                        $('<td />', {class: 'folder-size'}).html(folderList[i].size).appendTo($_tr);


                        $('<td />').html(buttonPanel).appendTo($_tr);
                        $("#folder-list tbody").append($_tr);
                    }
                    bindDialog();
                }
            } else {
                errorMessages(dataObject.errors);
            }
            var rootFolder = (parentFolder == "/" && folder == "") ? "/" : parentFolder + folder + "/";
            rootFolder=rootFolder.replace("//","/");
            $("#root-folder").html(rootFolder)
            // $("#input_up_level").attr({"data-Folder": parentFolder});

        });
    }
    var getSelectedFolderList = function (withParent) {
        var folders = [];
        var parenrFolder = "";
        if (withParent)
            parenrFolder = $("#root-folder").html();
        var checkedElementList = $("#folder-list input:checked").parent().parent();
        for (var i = 0; i < checkedElementList.length; i++) {
            folders[i] = parenrFolder + $(checkedElementList[i]).attr("folder-name");
        }
        return folders;
        //console.log(folders);
    }
    var isSelectedFolder = function (targetFolder, folderList) {
        //console.log(folderList);
        for (var i = 0; i < folderList.length; i++) {
            if (targetFolder == folderList[i])
                return true;
        }
        return false;
    }

    var displayFolderPopup = function (parentFolder, folder) {
        $.ajax({
            type: "GET",
            url: siteUrl + "index/folder",
            data: {folder: folder, parentFolder: parentFolder}
        }).done(function (msg) {
            var moveFolderList = getSelectedFolderList(true);
            $("#folder-list-in-pop-up").find("tr").remove();
            var dataObject = jQuery.parseJSON(msg);
            if (dataObject.errorCount == 0) {
                var folderList = dataObject.data;
                if (folderList.length > 0) {
                    if (parentFolder == "/" && folder == "") {
                        var $_tr1 = $(document.createElement('tr'));
                        $('<a />').html("/").appendTo($('<td />').appendTo($_tr1));
                        $('<a />', {
                            "data-Folder": "",
                            class: "folder-link-choose",
                            href: "#"
                        }).html("Move Here..").appendTo($('<td />').appendTo($_tr1));
                        $("#folder-list-in-pop-up").append($_tr1);
                    }
                    for (var i = 0; i < folderList.length; i++) {
                        if ("dir" == folderList[i].type) {
                            if (!isSelectedFolder(parentFolder + folderList[i].name, moveFolderList)) {

                                var $_tr = $(document.createElement('tr'));
                                $('<a />', {
                                    "data-Folder": folderList[i].name,
                                    class: "folder-link",
                                    href: "#"
                                }).html(folderList[i].name).appendTo($('<td />').appendTo($_tr));
                                $('<a />', {
                                    "data-Folder": folderList[i].name,
                                    class: "folder-link-choose",
                                    href: "#"
                                }).html("Move Here..").appendTo($('<td />').appendTo($_tr));
                                $("#folder-list-in-pop-up").append($_tr);
                            }
                        }

                    }
                }
            } else {
                errorMessages(dataObject.errors);
            }
            var rootFolder = (parentFolder == "/" && folder == "") ? "/" : parentFolder + folder + "/";
            $("#popup-root").html(rootFolder)
        });
    }
    $("#folder-list-in-pop-up").on("click", ".folder-link", function () {
        var folder = $(this).attr("data-folder");
        var parentFolder = $("#popup-root").html();
        displayFolderPopup(parentFolder, folder);
        return false;

    });
    $("#input-move-all").bind("click", function () {
        if ($("#folder-list input:checked").length > 0) {
            folderSelectDialog.dialog("open");
            displayFolderPopup("/", "");
        } else {
            alert("Please select at least one item for move.")
        }
    });
    $("#input-dell-all").bind("click", function () {
        if ($("#folder-list input:checked").length > 0) {
            if (confirm("do you need to delete this files")) {
              handleDeleteFiels();
            }
        } else {
            alert("Please select at least one item for move.")
        }
    });
    var movedFolder;
    $("#folder-list-in-pop-up").on("click", ".folder-link-choose", function () {
        var parenrFolder = $("#root-folder").html();
        // var  folder = $(this).attr("data-folder");
        folderSelectDialog.dialog("close");
        var moveFolderList = getSelectedFolderList(false);
        movedFolder = $(this).attr("data-folder")
        var moveToFolder = $("#popup-root").html() + movedFolder;
       // console.log(moveToFolder);
        $.ajax({
            type: "GET",
            url: siteUrl + "index/move",
            data: {parentFolder: parenrFolder, move_to: moveToFolder, files_or_folders_for_move: moveFolderList}
        }).done(function (msg) {
            $(".form-message").html("");
            var dataObject = jQuery.parseJSON(msg);
            if (dataObject.errorCount == 0) {
                infoMessages(dataObject.data);

                displayFolder($("#popup-root").html(), movedFolder);
            } else {
                errorMessages(dataObject.errors);
            }

        });

    });
    $("#input_folder_up_level").click(function () {
        var oldParentFolder = "";
        var folder = "";
        oldParentFolder = $("#popup-root").html();
        var parentFolder = "/";
        var parentSplit = oldParentFolder.split('/');
        if (parentSplit.length > 3) {
            folder = parentSplit[parentSplit.length - 3];
            for (var i = 1; i < parentSplit.length - 3; i++) {
                parentFolder += parentSplit[i] + "/";
            }

        }
        displayFolderPopup(parentFolder, folder);
    });
    $(".folder-info").on("click", ".folder-link", function () {

        var parentFolder = "";
        var folder = "";
        folder = $(this).attr("data-folder");
        if ($(this).hasClass("hasparent"))
        {
            parentFolder = $(this).attr("parent-folder")
        } else {
            parentFolder = $("#root-folder").html();
        }
        displayFolder(parentFolder, folder);

    });
    $("#input_up_level").click(function () {
        var oldParentFolder = "";
        var folder = "";
        oldParentFolder = $("#root-folder").html();
        var parentFolder = "/";
        var parentSplit = oldParentFolder.split('/');
        if (parentSplit.length > 3) {
            folder = parentSplit[parentSplit.length - 3];
            for (var i = 1; i < parentSplit.length - 3; i++) {
                parentFolder += parentSplit[i] + "/";
            }

        }
        displayFolder(parentFolder, folder);
    });




    bindDialog();

});