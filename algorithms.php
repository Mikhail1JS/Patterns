<?php

$foldersPath = $_GET['current-folder']??dirname(__FILE__);

$prevFolder = null;

if($foldersPath != dirname(__FILE__)){
    $prevFolder = dirname($foldersPath);
}



function render (string $path , ?string $prevFolder) {
    $dir = new DirectoryIterator($path);
    if(!is_null($prevFolder)){
        ?><a href="?current-folder=<?php echo $prevFolder ?>">Back</a></br>
        <?php
    }
    foreach ($dir as $item){


        if($item->isDot()) {
            continue;
        }

        if($item->isDir()){
            ?><a href="?current-folder=<?php echo $item->getPathname() ?>"><?php echo $item->getFilename() ?></a></br>
            <?php
        }else {
            echo $item->getFilename()."</br>";}
    }
}


render($foldersPath,$prevFolder);


?>




