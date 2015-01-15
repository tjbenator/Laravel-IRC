<?php namespace Tjbenator\irc;

use Config;

class Irc
{
	protected $socket = null;
	private $channels = array();
	private $username = null;
	private $registered = false;

	public function __construct()
	{
		$this->username = Config::get('tjbenator/irc::username');
		$this->channels = Config::get('tjbenator/irc::channels');
		$this->server = Config::get('tjbenator/irc::server');
		$this->port = Config::get('tjbenator/irc::port');
		$this->hostname = Config::get('tjbenator/irc::hostname');
		$this->nickservpass = Config::get('tjbenator/irc::nickservpass');
		$this->socket = fsockopen($this->server, $this->port);

		$this->send_data("NICK {$this->username}");
		$this->send_data("USER {$this->username} {$this->hostname} {$this->server} {$this->username}");

		$this->connect();		
	}

	public function __destruct()
	{
		socket_close($this->socket);
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
		$this->join($channel);
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
