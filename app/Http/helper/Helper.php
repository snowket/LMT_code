<?php

namespace App\Http\Helper;

class Helper
{

    public static function createMigrationFolder($folderName, $filename)
    {
        $folder = base_path() . env('MIGRATION_FOLDER_PATH') . '/' . env('LARAVEL_PROJECT_NAME') . "/" . $folderName . "/";
        Self::createModelFile($filename);
        Self::createControllerFile($folderName, $filename);
        if (file_exists($folder)) {
            return "Folder exists at :  " . $folder;
        } else {
            //Check if project folder exists in migrations
            if (file_exists(base_path() . env('MIGRATION_FOLDER_PATH') . env('LARAVEL_PROJECT_NAME'))) {
                mkdir(base_path() . env('MIGRATION_FOLDER_PATH') . env('LARAVEL_PROJECT_NAME') . $folderName, 0777);
            } else {
                mkdir(base_path() . env('MIGRATION_FOLDER_PATH') . env('LARAVEL_PROJECT_NAME'), 0777);
                mkdir(base_path() . env('MIGRATION_FOLDER_PATH') . env('LARAVEL_PROJECT_NAME') . $folderName, 0777);
            }
            return "Folder created :  " . $folder;

        }

    }
    public static function createModelFile($filename)
    {
        $folder = base_path() . env('MODEL_FOLDER_PATH');
        if (file_exists($folder . "" . $filename . ".php")) {
            return "File exists : " . $filename;
        } else {
            $fileCreate = shell_exec(env('LARAVEL_PROJECT_PATH') . ' && php artisan make:model ' . $filename . ' 2>&1');
        }
    }
    public static function createControllerFile($foldername, $filename)
    {
        $folder = base_path() . env('CONTROLLER_FOLDER_PATH') . $filename;
        if (file_exists($folder . "" . $filename . ".php")) {
            return "File exists : " . $filename;
        } else {
            $fileCreate = shell_exec(env('LARAVEL_PROJECT_PATH') . ' && php artisan make:controller ' . $filename . 'Controller 2>&1');
            if ($fileCreate === 'Controller already exists!') {
                return true;
            }
            $ad = self::filenaming($fileCreate);
            dd($ad);
        }
    }
    public static function createAdminConfigFile($filename)
    {
        $folder = base_path() . env('CONTROLLER_FOLDER_PATH') . $filename;
        if (file_exists($folder . "" . $filename . ".php")) {
            return "File exists";
        } else {
            $fileCreate = shell_exec(env('LARAVEL_PROJECT_PATH') . ' && php artisan make:controller ' . $filename . 'Controller 2>&1');
        }
    }
    public static function filenaming($filecreate)
    {

        if (($pos = strpos($filecreate, ":")) !== false) {
            $fileName = substr($filecreate, $pos + 1);
        }
        // file name
        $fileName = trim($fileName);

        if ($fileName) {
            return $Filename;
        } else {
            return false;
        }
    }
}
