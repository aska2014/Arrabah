<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrationCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'migrate:many';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create many migrations at once.';

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
	 * @return void
	 */
	public function fire()
	{
		$tables = $this->argument('tables');

		$tables = explode(',', $tables);

		foreach ($tables as $table)
		{
			$table = trim($table);

			exec( 'php artisan migrate:make create_' . $table . '_table --table=' . $table .' --create' );
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
			array('tables', InputArgument::REQUIRED, 'Tables to create migrations for.'),
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
		);
	}

}