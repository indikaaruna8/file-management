This is the basic MVC application to manage folders and files. The available features are
1. Create Folder
2. List Folders 
3. Delete folder 
5. Upload Files
5. Move Files

1. Create virtual  alias
----------------------------
    1.1 open your httpd.conf file   
    1.2 Add folowing line of code 

        Alias /antlabs "<your physicle path here>"

        <Directory "<your physicle path here>">
            Options FollowSymLinks
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted

            Allow from 127.0.0.1
            Allow from ::1
            Allow from localhost
            deny from 127.0.0.100

    </Directory>
  1.3 restart the apache server

2. Enable mod_rewrite
    2.1 Mac osx 
        http://www.jattcode.com/how-to-enable-mod_rewrite-on-macosx-mountain-lion/
    2.2 ubuntu 
        http://www.dev-metal.com/enable-mod_rewrite-ubuntu-12-04-lts/
    2.3 windos wamp 
       http://phpcollection.com/mod-rewrite-windows-wamp-xampp/

3. Open phpfm.ini and specify the top_dir and log file path.   
    3.1 Make sure to give all permission for top_dir
    3.2 Make suer to give write permission to log file

Note:
  Waring message will not be showing for Json return actions. 
  if you need to debug please comment ob_end_clean() funtion in index.php file in root folder
    