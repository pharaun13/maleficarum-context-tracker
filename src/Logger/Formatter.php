<?php


namespace Maleficarum\ContextTracing\Logger;


class Formatter
{
    /**
     * @param string $message
     * @param array $context
     * @return string
     */
    static public function format($message, array $context)
    {
        $newMessage = '';
        $f = function ($array) {
        };
        foreach ($context as $key => $value) {
            $value = self::flatten($value);
            $newMessage .= '[' . $key . ': ' . $value . '] ';
        }
        return $newMessage . $message;
    }

    static private function flatten($data)
    {
        $flat = '';
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $flat .= '[' . $key . ': ' . self::flatten($value) . ']';
            }

            return $flat;
        } else {
            return $data;
        }
    }
}