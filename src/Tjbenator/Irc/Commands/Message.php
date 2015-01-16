<?php namespace Tjbenator\Irc\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Message extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'irc:message';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Messages an IRC Channel';

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
		$this->info('Messaging ' . $this->argument('channel') . ": " . $this->argument('message'));
		\Irc::message($this->argument('channel'), $this->argument('message'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['channel', InputArgument::REQUIRED, 'Channel that you would like to message'],
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