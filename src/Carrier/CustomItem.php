<?php


namespace Maleficarum\ContextTracing\Carrier;


class CustomItem
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $default;

    /**
     * CustomItem constructor.
     * @param string $key
     * @param string $value
     * @param string|null $default
     */
    public function __construct($key, $value, $default)
    {
        $this->key = $key;
        $this->value = $value;
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getDefault()
    {
        return $this->default;
    }
}