#!/usr/bin/env bash

command_exists () {
    type "$1" &> /dev/null ;
}

if command_exists apigen ; then
    apigen generate --source invoke-helpers.php --destination api --template-theme bootstrap
else
    echo "You need to install apigen to build the docs. Please visit http://www.apigen.org/"
    exit 1
fi

