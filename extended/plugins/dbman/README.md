# dbman
The Dbman plugin backups/restores database WITHOUT using mysqldump(.exe).

## System requirements
1. Geeklog-1.6.0 or newer
2. PHP-5.x - 7.x

## Install
In the following descriptions,

**geeklog_dir** is the directory where the system db-config.php file resides
**public_html** is the directory where lib-common.php file resides
**admin** is the directory where the administration files reside (usually, under **public_html**)

1. Uncompress the dbman plugin archive while in the <geeklog_dir>/plugins directory. The archive will create a directory called dbman in the plugins directory.
Under your **admin**/plugins/ directory, create a directory called dbman.
2. Change to your **geeklog_dir**/plugins/dbman/admin directory and copy the files in the directory to the **admin**/plugins/dbman directory your created in step 2.
3. Log in to your Geeklog as a root user, go to the plugin editor and install Dbman plugin.

## Uninstall

1. Log in to your Geeklog as a root user and uninstall the Dbman plugin from plugin editor.
2. Delete the two plugin directories created in the install process: **geeklog-dir**/plugins/dbman and **admin**/plugins/dbman.
