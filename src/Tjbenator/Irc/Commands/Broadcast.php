<?php namespace Tjbenator\Irc\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Broadcast extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'irc:broadcast';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Broadcast to all IRC Channels in config';

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
		$this->info("Broadcasting: " . $this->argument('message'));
		\Irc::broadcast($this->argument('message'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['message', InputArgument::REQUIRED, 'Message you would like to send'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	// protected function getOptions()
	// {
	// 	return array(
	// 		array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
	// 	);
	// }

}