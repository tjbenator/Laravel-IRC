<?php namespace Tjbenator\irc;

use Config;

class Irc
{
	protected $socket = null;
	private $channels = array();
	private $username = null;
	private $registered = false;

	public function __construct($app) {
		$this->app = $app;
		$this->username = $this->app['config']['irc::username'];
		$this->channels = $this->app['config']['irc::channels'];
		$this->server = $this->app['config']['irc::server'];
		$this->port = $this->app['config']['irc::port'];
		$this->hostname = $this->app['config']['irc::hostname'];
		$this->nickservpass = $this->app['config']['irc::nickservpass'];
		$this->joinchannels = $this->app['config']['irc::joinchannels'];
		$this->socket = fsockopen($this->server, $this->port);


		$this->send_data("NICK {$this->username}");
		$this->send_data("USER {$this->username} {$this->hostname} {$this->server} {$this->username}");

		$this->connect();		
	}

	public function __destruct()
	{
		if ($this->socket)
		{
			fclose($this->socket);
		}
	}

	private function connect()
	{
		while ($data = fgets($this->socket))
		{
			flush();
			$ex = explode(" ", $data);

			if ($ex[0] == "PING")
			{
				$this->send_data("PONG " . $ex[1]);
				if ($this->nickservpass)
					$this->send_data("NICKSERV IDENTIFY {$this->nickservpass}");
				return;
			}
		}
	}

	private function send_data($data)
	{
		fputs($this->socket, "$data\r\n");
	}

	private function say($channel, $string) {
		$this->send_data("PRIVMSG $channel $string");
	}

	private function join($channel) {
		$this->send_data("JOIN $channel");
	}

	public function message($channel, $message)
	{
		#Only join if it is actually a channel
		if ($this->joinchannels && preg_match('/#(\w*[a-zA-Z_0-9]+\w*)/', $channel))
		{
			$this->join($channel);
		}

		#Say message in channel or at user
		$this->say($channel, $message);
	}

	public function broadcast($message, $channels = null)
	{
		$channels = (is_null($channels)) ? $this->channels : $channels;
		foreach ($channels as $channel)
		{
			$this->message($channel, $message);
		}
	}
}
