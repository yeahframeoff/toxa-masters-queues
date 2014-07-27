<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use libs\User;

class ProcessCsv extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'process:csv';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Parse given csv and retrieve images';

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
		$path = $this->argument('path');
        $so = $this->option('save_original');

        try
        {
            $file = new Keboola\Csv\CsvFile($path, ';');
        }
        catch(Keboola\Csv\Exception $e)
        {
            $this->error ($e->getMessage());
            return;
        }

        $width = (int) $this->ask('Please, input resize width:');
        while ($width <= 0)
            $width = $this->ask('Please, input CORRECT resize width:');

        $height = (int) $this->ask('Please, Input resize height:');

        while ($height <= 0)
            $height = $this->ask('Please, input CORRECT resize height:');


        foreach($file as $row)
        {
            $user = new User($row);
            $this->info($user);
            if (isset($user->pictureUrl))
                Queue::push('libs\UrlImageProcess', [
                    'source_image_url' => $user->pictureUrl,
                    'resize_to_width'  => $width,
                    'resize_to_height' => $height,
                    'save_original'    => $so,
                    'id'               => $user->id,
                ]);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('path', InputArgument::REQUIRED, 'Path to csv file'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('save_original', null, InputOption::VALUE_NONE, 'Use it to save full size sources too.', null),
		);
	}

}
