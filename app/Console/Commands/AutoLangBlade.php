<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AutoLangBlade extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'autolang:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$directory=base_path()."/resources/views";
        $this->readdir($directory);
        
        
	}
    
    private function readdir($path) {
        
        $ficheros=scandir($path);
        foreach($ficheros as $fichero) {
            if($fichero!='.' && $fichero!="..") {
                $partes_fichero=explode(".", $fichero);
                if(count($partes_fichero)>1) {
                    if($partes_fichero[count($partes_fichero)-1]=="php" && $partes_fichero[count($partes_fichero)-2]=="blade") {
                       
                        $this->info($path."/".$fichero);
                        $html=file_get_contents($path."/".$fichero, FILE_USE_INCLUDE_PATH ); 
                        $doc = new DOMDocument();

                    }
                }
                else $this->readdir($path."/".$fichero);
            }
        }
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	/*protected function getArguments()
	{
		return [
			['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}*/

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	/*protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}*/

}
