<?php


namespace Miinto\ContextTracing;


interface SpanInterface
{
	/**
	 * @param string $key
	 * @param string$value
	 * @return void
	 */
	public function addTag($key, $value);

    /**
     * @param string $key
     * @param string$value
     * @return void
     */
    public function addItem($key, $value);

	/**
	 * @return array
	 */
	public function transfer();
}
