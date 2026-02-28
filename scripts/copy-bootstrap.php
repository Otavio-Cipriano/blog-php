<?php


$source = __DIR__ . '/../vendor/twbs/bootstrap/dist';
$destination = __DIR__ . '/../public/assets/bootstrap';

function copyDir($src, $dst)
{
    //Check if folde exists in public
    if (!is_dir($dst)) {
        //if folder doesn't exists, he creates
        mkdir($dst, 0777, true);
    }

    //scan the source foldder, and creates a array with folder files and dirs
    $files = scandir($src);

    //Loop over files in source folder
    foreach ($files as $file) {
        //check to see wich $file is another folder
        if ($file === '.' || $file === '..') continue;

        //creates a path to copy the folders
        $srcPath = "$src/$file";
        $dstPath = "$dst/$file";

        //if file is a directory, copy directory
        if (is_dir($srcPath)) {
            copyDir($srcPath, $dstPath);
        }//if file is a file, copy file
        else {
            copy($srcPath, $dstPath);
        }
    }
}

copyDir($source, $destination);

echo "Bootstrap copiado com sucesso!";