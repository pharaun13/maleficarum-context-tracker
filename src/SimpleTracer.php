<?php


namespace Miinto\ContextTracing;

class SimpleTracer implements TracerInterface {
	/**
	 * @var SpanInterface
	 */
	private $currentSpan;

	/**
	 * @inheritDoc
	 */
	private function startSpan($operationName) {
		$this->currentSpan = new SimpleSpan($operationName);
	}

	/**
	 * @inheritDoc
	 */
	public function startChildSpan($operationName) {

		$this->currentSpan = new SimpleSpan($operationName, $this->getCurrentSpan());
	}

	/**
	 * @inheritDoc
	 */
	public function addTag($key, $value) {
		$this->getCurrentSpan()->addTag($key, $value);
	}

	/**
	 * @return SpanInterface
	 */
	private function getCurrentSpan() {
		if (!$this->currentSpan instanceof SpanInterface) {
			$this->startSpan($this->getDefaultOperationName());
		}
		return $this->currentSpan;
	}

	public function injectIntoMessage(array $message) {
		//todo limit rozmiaru
		$context = $this->getCurrentSpan()->transfer();
		if (!array_key_exists('__meta', $message)) {
			$message['__meta'] = [];
		}
		$message['__meta']['context'] = $context;

		return $message;
	}

    public function createSpanFromContext(array $context) {
        if (array_key_exists('operation', $context)) {
            $this->startSpan($context['operation']);
        }
        if (array_key_exists('items', $context)) {
            foreach ($context['items'] as $k => $v) {
                $this->addItem($k, $v);
            }
        }
    }

    public function addItem($key, $value) {
        $this->getCurrentSpan()->addItem($key, $value);
    }

    /**
     * @return string
     */
    private function getDefaultOperationName(): string {
        return getHostName();
    }

    /**
     * @return array
     */
    public function flatten()
    {
        return $this->getCurrentSpan()->flatten();
    }

}
