<?php


namespace ContextTracing;

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
	 * @todo rozdzielić na baggageItems a tags - tags tylko lokalnie a items są przesyłane
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
            $this->startChildSpan($context['operation']);
        }
        if (array_key_exists('items', $context)) {
            foreach ($context['items'] as $k => $v) {
                $this->addTag($k, $v);
            }
        }
    }

    public function addItem($key, $value) {
        // TODO: Implement addItem() method.
    }

    /**
     * @return string
     */
    private function getDefaultOperationName(): string {
        return getHostName();
    }

    public function __toString()
    {
        json_encode($this->getCurrentSpan()->transfer());
    }


}
