<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {filePath}'; // The command's signature
    protected $description = 'Create a new service class'; // Description of the command



    public function handle()
    {
        if (!is_dir(app_path('Service'))) {
            mkdir(app_path('Service'));
        }

        $filePath = $this->argument('filePath');

        if (file_exists(app_path('Service/' . $filePath . '.php'))) {
            echo 'File already exists!';
        } else {
            $spl_paths = explode('/', $filePath);
            $className = $spl_paths[count($spl_paths) - 1];
            $fullFilePath = array_filter(
                $spl_paths,
                fn ($value) =>
                $value !== $className
            );

            $fullFilePath = implode('/', $fullFilePath);

            $base_content = <<<EOD
            <?php

            namespace App\Service;

            class $className {

            }
            EOD;

            $file = fopen(app_path('Service/' . ($fullFilePath ? '/' : '') . $className . '.php'), 'w') or die('Unable to open file!');

            fwrite($file, $base_content);
            echo 'Service Created Successfully';
            fclose($file);
        }
    }
}
