<?php
$it = new RecursiveDirectoryIterator("c:/xampp/htdocs/shopping");
foreach(new RecursiveIteratorIterator($it) as $file) {
    if ($file->isFile() && $file->getExtension() == 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, "preview mode") !== false) {
            echo "Found in: " . $file->getPathname() . "\n";
        }
    }
}
?>
