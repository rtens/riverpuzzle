<?php

function loadClass($className) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
}

spl_autoload_register("loadClass", true);