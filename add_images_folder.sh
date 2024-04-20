#!/bin/bash

if [ "$#" -ne 1 ]; then
  echo -e 'You need to pass directory name \n ./add_images_folder.sh IMAGE_FOLDER_NAME'
  exit 2
fi

if ! [ -d public/uploads/images/${1} ]; then
  echo "Creating ${1} folder..."
  mkdir -p public/uploads/images/${1}
fi

IGNORE="*\n!.gitignore"

if ! [ -f public/uploads/images/${1}/.gitignore ]; then
  echo "Adding .gitignore file..."
  touch public/uploads/images/${1}/.gitignore
fi

echo "Writing to .gitignore to ignore all files in ${1} directory"
echo -e $IGNORE > public/uploads/images/${1}/.gitignore