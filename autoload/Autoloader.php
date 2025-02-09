<?php
// autoload/Autoloader.php

class Autoloader {
    public static function register() {
        spl_autoload_register(function ($className) {
            // Define base directory
            $baseDir = dirname(__DIR__);
            
            // Define mapping of class types to directories
            $dirMapping = [
                'Controller' => 'controller',
                'Repository' => 'repositories',
                'Model' => 'model',
                'Exception' => 'exceptions'
            ];
            
            // Try to determine the type and directory from the class name
            $directory = null;
            foreach ($dirMapping as $type => $dir) {
                if (strpos($className, $type) !== false) {
                    $directory = $dir;
                    break;
                }
            }
            
            // If no specific directory found, try all possible locations
            if ($directory === null) {
                $possiblePaths = [
                    $baseDir . '/model/' . $className . '.php',
                    $baseDir . '/controller/' . $className . '.php',
                    $baseDir . '/repositories/' . $className . '.php',
                    $baseDir . '/config/' . $className . '.php'
                ];
                
                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        require_once $path;
                        return;
                    }
                }
            } else {
                // Load from determined directory
                $path = $baseDir . '/' . $directory . '/' . $className . '.php';
                if (file_exists($path)) {
                    require_once $path;
                    return;
                }
            }
        });
    }
}