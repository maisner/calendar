<?php

namespace Maisner\Calendar\Result;

class OneServiceActionResult {

	/** @var string */
	private $service;

	/** @var bool */
	private $success;

	/** @var string */
	private $message;

	/** @var string */
	private $eventId;

	public function __construct(string $service, bool $success = TRUE, string $message = '', string $eventId = '') {
		$this->service = $service;
		$this->success = $success;
		$this->message = $message;
		$this->eventId = $eventId;
	}

	public function getService(): string {
		return $this->service;
	}

	public function isSuccess(): bool {
		return $this->success;
	}

	public function getMessage(): string {
		return $this->message;
	}

	public function getEventId(): string {
		return $this->eventId;
	}

	public static function createSuccessResult(string $service, string $eventId): self {
		return new self($service, TRUE, '', $eventId);
	}

	public static function createFailedResult(string $service, string $message, ?string $eventId = NULL): self {
		return new self($service, FALSE, $message, $eventId ?? '');
	}
}