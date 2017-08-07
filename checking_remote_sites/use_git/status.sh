#! /bin/bash
checkStatus(){
	echo $1;
	gitstatus=`git status`;
	if [ "$gitstatus" = "$cleanString" ]
	then echo "Clean"
	else cd "$path/.." &&  echo "$gitstatus" | grep modified | awk '{print $2$3}' | xargs php post.php $1
	fi
}
CONFIG_PATH='./config.ini'
. "${CONFIG_PATH}"
cd "$path"
checkStatus "$fromName"
