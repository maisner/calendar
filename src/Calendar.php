<?php

namespace Maisner\Calendar;

use Maisner\Calendar\Wrapper\ICalendarWrapper;

class Calendar {

	/** @var array|ICalendarWrapper[] */
	private $wrappers = [];

	public function addWrapper(ICalendarWrapper $wrapper): void {
		$this->wrappers[\get_class($wrapper)] = $wrapper;
	}

	public function insertEvent(Event $event): void {
		foreach ($this->wrappers as $wrapper) {
			$wrapper->insertEvent($event);
		}
	}

	public function updateEvent(Event $event): void {
		foreach ($this->wrappers as $wrapper) {
			$wrapper->updateEvent($event);
		}
	}

	public function removeEvent(Event $event): void {
		foreach ($this->wrappers as $wrapper) {
			$wrapper->removeEvent($event);
		}
	}
}