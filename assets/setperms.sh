#!/bin/bash

OWNER_NAME=$1
GROUP_NAME=$2
THIS_FILE_PATH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
APP_ROOT_PATH=$THIS_FILE_PATH'/..'


BOOTSRAP_CACHE_PATH=$APP_ROOT_PATH'/bootstrap/cache'
STORAGE_PATH=$APP_ROOT_PATH'/storage'

DIRECTORIES="$BOOTSRAP_CACHE_PATH $STORAGE_PATH"

if [ -z "$OWNER_NAME" ] || [ -z "$GROUP_NAME" ]; then
	echo "   Usage: setperms user group"
	echo "    e.g.: setperms root apache"
	echo "    e.g.: setperms admin _www"
	exit 1
fi


echo "Check if user name '$OWNER_NAME' exists"
DOES_NOT_EXISTS=true
id -u $OWNER_NAME >/dev/null 2>&1 && DOES_NOT_EXISTS=false
if $DOES_NOT_EXISTS ; then
	echo "User name '$OWNER_NAME' doesn't exist."
	exit 2
fi


echo "Check if group name '$GROUP_NAME' exists"
DOES_NOT_EXISTS=true
id -g $GROUP_NAME >/dev/null 2>&1 && DOES_NOT_EXISTS=false
if $DOES_NOT_EXISTS ; then
	echo "Group name '$GROUP_NAME' doesn't exist."
	exit 3
fi


echo "Check all directories exists"
DOES_NOT_EXISTS=false
for DIRECTORY in $DIRECTORIES
do
	if [ ! -d "$DIRECTORY" ]; then
		echo "Directory '$DIRECTORY' doesn't exist."
		DOES_NOT_EXISTS=true
	fi
done
if $DOES_NOT_EXISTS ; then
	exit 4
fi


echo "Change files owner to $OWNER_NAME"
sudo chown -R $OWNER_NAME:$OWNER_NAME $APP_ROOT_PATH


echo "Set write permission only for $OWNER_NAME"
sudo chmod -R -x $APP_ROOT_PATH
sudo chmod -R u=rw,go=r,a+X,a-s $APP_ROOT_PATH


echo "Set execute permission for bash files"
find $THIS_FILE_PATH -type f -name '*.sh' -exec chmod +x {} \;
find $APP_ROOT_PATH'/.git/hooks' -type f -not -name '*.sample' -exec chmod +x {} \;
chmod +x $APP_ROOT_PATH'/artisan'

echo "Set write permission for $GROUP_NAME"
for DIRECTORY in $DIRECTORIES
do
	sudo chgrp -R $GROUP_NAME $DIRECTORY
	sudo chmod a+s $DIRECTORY
	sudo chmod -R g+w $DIRECTORY
	sudo find $DIRECTORY -type d -exec chmod g+s {} \;
	sudo find $DIRECTORY -name .gitignore -exec chmod u=rw,go=r {} \;
	sudo find $DIRECTORY -name .gitignore -exec chown $OWNER_NAME:$OWNER_NAME {} \;
	sudo setfacl -d -m g::rwx $DIRECTORY 2> /dev/null
	sudo setfacl -d -m o::rx  $DIRECTORY 2> /dev/null || sudo chmod +a "group:$GROUP_NAME allow write,file_inherit" $DIRECTORY 2> /dev/null
done


echo "All permissions have been set"
