<?php


namespace Maleficarum\ContextTracing;

class SimpleTracer implements TracerInterface
{

    const MASTER_ID = 'masterId';
    const CURRENT_ID = 'currentId';
    const LAST_ID = 'lastId';


    /*
     * @var string[]
     */
    private $tags = [];

    /*
     * @var string[]
     */
    private $items = [];


    /**
     * @inheritDoc
     */
    public function addTag($key, $value)
    {
        $this->tags[$key] = $value;
    }

    public function addItem($key, $value)
    {
        $this->items[$key] = $value;
    }


    public function getItem($key)
    {
        return $this->hasItem($key) ? $this->items[$key] : null;
    }

    public function hasItem($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @return array
     */
    public function flatten()
    {
        return [
            'tags' => array_merge($this->tags, [
                self::MASTER_ID => $this->getItem(self::MASTER_ID),
                self::LAST_ID => $this->getItem(self::LAST_ID),
                self::CURRENT_ID => $this->getItem(self::CURRENT_ID),
            ])
        ];
    }
}
