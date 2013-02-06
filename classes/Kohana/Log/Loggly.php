<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Loggly log writer.
 *
 * Writes application logs to the Loggly.com SAAS over an external HTTPS request
 *
 * @package    Kohana/Loggly
 * @category   Logging
 * @author     Ando Roots <ando@sqroot.eu>
 * @copyright  (c) 2013 Ando Roots
 */
class Kohana_Log_Loggly extends Log_Writer
{

	/**
	 * Assume all Loggly input keys are exactly 36 char
	 */
	const LOGGLY_KEY_LENGTH = 36;

	/**
	 * Loggly API URL
	 */
	const LOGGLY_INPUT_URL = 'https://logs.loggly.com/inputs/';

	/**
	 * Log request timeout in seconds.
	 * The external logging request will be aborted if it takes longer than this.
	 */
	const LOG_REQUEST_TIMEOUT = 6;

	/**
	 * @var string Loggly input key
	 */
	private $_loggly_input_key;

	public function __construct($loggly_input_key)
	{
		if (! Valid::exact_length($loggly_input_key, self::LOGGLY_KEY_LENGTH))
		{
			throw new Kohana_Exception('Loggly input key must be exactly :length characters long.', [
				':length' => self::LOGGLY_KEY_LENGTH
			]);
		}
		$this->_loggly_input_key = $loggly_input_key;
	}


	/**
	 * Write an array of messages.
	 *
	 *     $writer->write($messages);
	 *
	 * @param   array   $messages
	 * @return  void
	 */
	public function write(array $messages)
	{
		foreach ($messages as $message)
		{

			Request::factory(
				self::LOGGLY_INPUT_URL.$this->_loggly_input_key,
				[
					CURLOPT_TIMEOUT => self::LOG_REQUEST_TIMEOUT
				]
			)
				->method(HTTP_Request::POST)
				->headers('Content-Type', 'application/json')
				->body($this->format_message($message))
				->execute();
		}
	}

	/**
	 * Formats a log entry.
	 *
	 * @param array $message
	 * @param string $format
	 * @return string
	 */
	public function format_message(array $message, $format = "time --- level: body in file:line")
	{
		// Don't include trace by default
		if (! isset($message['additional']['exception']) && array_key_exists('trace', $message))
		{
			unset($message['trace']);
		}

		if (empty($message['additional']))
		{
			unset($message['additional']);
		}

		return json_encode($message);
	}
}