<?php


namespace ContextTracing;


interface TracerInterface
{

	/**
	 * @param string $operationName
	 * @return void
	 */
	public function startChildSpan($operationName);


	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function addTag($key, $value);

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function addItem($key, $value);

    public function injectIntoMessage(array $message);

    public function createSpanFromContext(array $context);

    /**
     * @return string
     */
    public function __toString();

}
