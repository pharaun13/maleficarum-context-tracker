<?php


namespace Miinto\ContextTracing;


class SimpleSpan implements SpanInterface
{
	/*
	 * @var string[]
	 */
	private $tags = [];

    /*
     * @var string[]
     */
    private $items = [];

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var SimpleSpan|null
	 */
	private $parentSpan;

	/**
	 * SimpleSpan constructor.
	 * @param string $name
	 */
	public function __construct($name, $parentSpan = null)
	{
		$this->name = $name;
		$this->parentSpan = $parentSpan;
	}


	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addTag($key, $value)
	{
		$this->tags[$key] = $value;
	}

    public function addItem($key, $value) {
        $this->items[$key] = $value;
    }

	public function __toString()
	{
		return json_encode($this->tags);
	}

	public function transfer()
	{
		return [
			'operation' => $this->getOperationName(),
			'items' => $this->getItems()
		];
	}

    public function flatten()
    {
        return [
            'operation' => $this->getOperationName(),
            'items' => $this->getItems(),
            'tags' => $this->getTags(),
        ];
    }

	public function getOperationName()
	{
		return ($this->parentSpan ? $this->parentSpan->getOperationName() . '||'  : '' ) . $this->name;
	}

    public function getTags()
	{
		return array_merge($this->tags, ($this->parentSpan ? $this->parentSpan->getTags() : [] ));
	}

    public function getItems()
    {
        return array_merge($this->items, ($this->parentSpan ? $this->parentSpan->getItems() : [] ));
    }


}
