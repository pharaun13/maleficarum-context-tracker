<?php


namespace ContextTracing;


class ContextTracker
{

	static public function clearContext() {
		self::$tracer = new SimpleTracer();
	}

	/**
	 * @var TracerInterface
	 */
	static private $tracer;

	/**
	 * @return TracerInterface
	 */
	static public function getTracer() {
	    if(!self::$tracer instanceof TracerInterface) {
	        self::$tracer = new SimpleTracer();
        }
		return self::$tracer;
	}

}
