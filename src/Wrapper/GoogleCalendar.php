<?php

namespace Maisner\Calendar\Wrapper;

use Maisner\Calendar\Event;

class GoogleCalendar implements ICalendarWrapper {

	/** @var string */
	protected $authFile;

	/** @var string */
	protected $googleCalendarId;

	public function __construct(string $authFile, string $googleCalendarId) {

		$this->authFile = $authFile;
		$this->googleCalendarId = $googleCalendarId;
	}

	public function getCalendarId(): string {
		return $this->googleCalendarId;
	}

	public function getEvent(string $id): Event {
		// TODO: Implement getEvent() method.
	}

	public function insertEvent(Event $event): void {
		// TODO: Implement insertEvent() method.
	}

	public function updateEvent(Event $event): void {
		// TODO: Implement updateEvent() method.
	}

	public function removeEvent(Event $event): void {
		// TODO: Implement removeEvent() method.
	}
}