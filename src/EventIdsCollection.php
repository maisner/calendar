<?php

namespace Maisner\Calendar;

class EventIdsCollection {

	/** @var array */
	private $ids;

	public function __construct() {
		$this->ids = [];
	}

	public function addEventId(string $service, string $eventId): void {
		$this->ids[$service] = $eventId;
	}

	/**
	 * @return array|string[]
	 */
	public function getEventIds(): array {
		return $this->ids;
	}

	public function getEventId(string $service): ?string {
		return $this->ids[$service] ?? NULL;
	}
}