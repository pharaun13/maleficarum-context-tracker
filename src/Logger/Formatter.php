<?php


namespace Maleficarum\ContextTracing\Logger;


class Formatter
{
    /**
     * @param string $message
     * @param array $context
     * @return string
     */
    static public function format($message, array $context) {
        $newMessage = '';
        foreach($context as $key => $value) {
            $newMessage .= '[' . $key . ': ' . $value . '] ';
        }
        return $newMessage . $message;
    }
}