<?php

namespace Email;
use Config, Markdown;

/**
 * Swift Mailer wrapper.
 * 
 *     Smtp::send($message);
 * 
 * - Converts body to HTML as Markdown
 * - Sets sender to configured sender
 * - Sends message with configured SMTP details
 * 
 * @uses Config email
 */
class Smtp
{
	use \Candy\InstanceCallable;

	public function __construct()
	{
		$this->config = Config::email();
	}

	protected function send(\Swift_Message $message): bool
	{
		// Set sender
		$message->setSender($this->config['smtp']['sender']);

		// Create transport
		$transport = (new \Swift_SmtpTransport)
			->setEncryption('tls')
			->setHost($this->config['smtp']['server'])
			->setPort($this->config['smtp']['port'])
			->setUsername($this->config['smtp']['username'])
			->setPassword($this->config['smtp']['password']);

		// Send message
		$mailer = (new \Swift_Mailer($transport));
		$mailer->registerPlugin(new SwiftLoggerPlugin);
		return $mailer->send($message) > 0;
	}
}
