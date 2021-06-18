<?php


namespace Maleficarum\ContextTracing;


interface TracerInterface
{
	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function addTag($key, $value);

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function addItem($key, $value);

    /**
     * @param string $key
     * @return bool
     */
    public function hasItem($key);

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getItem($key);

    /**
     * @return array
     */
    public function flatten();
}
