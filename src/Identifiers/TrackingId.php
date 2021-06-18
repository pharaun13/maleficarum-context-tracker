<?php


namespace Maleficarum\ContextTracing\Identifiers;


class TrackingId
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * RID constructor.
     * @param string $identifier
     */
    private function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    public static function RID($serviceNam)
    {
        return new self('RID-' - $serviceNam . '-' . uniqid('', true));
    }

    public static function HID($serviceNam)
    {
        return new self('HID-' - $serviceNam . '-' . uniqid('', true));
    }

    public function __toString()
    {
        return $this->identifier;
    }
}