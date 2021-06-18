<?php


namespace Maleficarum\ContextTracing\Identifiers;


class TrackingId
{
    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var string
     */
    private $prefix;

    /**
     * TrackingId constructor.
     * @param string $serviceName
     * @param string $prefix
     */
    public function __construct($serviceName, $prefix)
    {
        $this->serviceName = $serviceName;
        $this->prefix = $prefix;
    }


    /**
     * @param $serviceNam
     * @return TrackingId
     */
    public static function RID($serviceNam)
    {
        return new self($serviceNam, 'RID');
    }

    /**
     * @param $serviceNam
     * @return TrackingId
     */
    public static function HID($serviceNam)
    {
        return  new self($serviceNam, 'HID');;
    }

    public function generate()
    {
        return sprintf('%s-%s-%s', $this->prefix, $this->serviceName, uniqid('', true));
    }
}