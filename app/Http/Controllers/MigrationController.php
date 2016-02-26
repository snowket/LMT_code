<?php

namespace App\Http\Controllers;

use App\Fields;
use App\Http\helper\Helper as helper;
use App\Migration;
use Illuminate\Http\Request;

class MigrationController extends Controller
{

    public function index()
    {
        $migrations = Migration::with('fields')->get();
        return view('migrations', compact('migrations'));
    }

    public function saveMigration(Request $request)
    {
        $folder = $request->input('folder');

        $migrationTemplate = base_path() . '/public/templates/migration.txt';
        if (!empty($folder)) {

            $newFolder = helper::createMigrationFolder($folder, $request->input('name'));
            $newFolder = trim($newFolder, '/');
            $id = substr($newFolder, strrpos($newFolder, '/') + 1);
            $filePath = base_path() . env('MIGRATION_FOLDER_PATH') . env('LARAVEL_PROJECT_NAME') . $id . '/';

            $out = shell_exec("cd ../../video/ & php artisan make:migration test ");

            $fileCreate = shell_exec(env('LARAVEL_PROJECT_PATH') . ' && php artisan make:migration '
                . $request->input('name') . ' --path="database/migrations/'
                . env('LARAVEL_PROJECT_NAME') . '/' . $id . '/" 2>&1');

            $migration = Migration::create(['folder' => $request->input('folder'), 'name' => $request->input('name')]);
        } else {
            $filePath = base_path() . env('MIGRATION_FOLDER_PATH');
            $fileCreate = shell_exec(env('LARAVEL_PROJECT_PATH') . ' && php artisan make:migration ' . $request->input('name'));
            $migration = Migration::create(['name' => $request->input('name')]);
        }

        if (($pos = strpos($fileCreate, ":")) !== false) {
            $fileName = substr($fileCreate, $pos + 1);
        } else {
            exit('error to create file');
        }

        // file name
        $fileName = trim($fileName);
        $migration->file_name = $fileName;
        $migration->save();
        // Get Content
        $migrationTemplateContent = file_get_contents($migrationTemplate, FILE_USE_INCLUDE_PATH);

        // Replace Class Name
        $migrationTemplateContent = str_replace('%className%', ucfirst($request->input('name')), $migrationTemplateContent);
        $migrationTemplateContent = str_replace('%tableName%', $request->input('name'), $migrationTemplateContent);
        file_put_contents($filePath . $fileName . '.php', $migrationTemplateContent);

        return json_encode($migration);
    }

    public function saveColumns(Request $request)
    {
        $migration = Migration::find($request->input('model_id'));

        $field = new Fields();

        $field->type = $request->input('type');
        $field->name = $request->input('name');
        $field->relationship = $request->input('un_index');
        $field->relationship_table = $request->input('rel_table');
        $field->relationship_on = $request->input('rel_on');

        $migration->fields()->save($field);
        self::tableSync($migration->id);
        return json_encode('OK');

    }
    public function removeColumn($id)
    {
        $fild = Fields::find($id);
        if ($fild->delete()) {
            $date = self::tableSync($fild->LMT_migrations_id);

        } else {

        }
        return redirect('/migration');

    }

    //Syncing Table Content With Database
    public function tableSync($in)
    {
        $migration = Migration::find($in);
        if ($migration->folder == 'NULL') {
            $filePath = base_path() . env('MIGRATION_FOLDER_PATH') . '/' . $migration->file_name . '.php';
        } else {
            $filePath = base_path() . env('MIGRATION_FOLDER_PATH') . env('LARAVEL_PROJECT_NAME') . $migration->folder . '/' . $migration->file_name . '.php';

        }
        $migrationTemplateContent = file_get_contents($filePath, FILE_USE_INCLUDE_PATH);
        $table = "" . PHP_EOL;
        foreach ($migration->fields as $field) {
            if (!strcmp($field->relationship, 'on')) {
                $table .= '$table->' . $field->type . '("' . $field->name . '");' . PHP_EOL;
                $table .= '$table->foreign("'
                . $field->name . '")->references("'
                . $field->relationship_table . '")->on("' . $field->relationship_on . '")->onDelete("CASCADE");' . PHP_EOL;
            } else {
                $table .= '$table->' . $field->type . '("' . $field->name . '");' . PHP_EOL;
            }
        }
        $table .= "//%tableBody%";
        $parsed = self::get_string_between($migrationTemplateContent, '//%tableStart%', '//%tableEnd%');
        $migrationTemplateContent = str_replace($parsed, $table, $migrationTemplateContent);
        file_put_contents($filePath, $migrationTemplateContent);
        return json_encode("DB Sync OK");
    }
    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }

        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}
