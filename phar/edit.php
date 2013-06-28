<?php
try {
    $phar = new Phar(dirname(__DIR__) . '/test.phar');
    $phar['index.php'] = '<?php echo "Hello World"; ?>';
    $phar->setStub('#!/usr/bin/php' . PHP_EOL . '<?php
Phar::webPhar();
__HALT_COMPILER(); ?>');
    //$phar->convertToExecutable(Phar::PHAR); // creates myphar.phar
} catch (Exception $e) {
    // handle error here
    echo $e->getMessage();
}