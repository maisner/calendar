<?php

namespace Maisner\Calendar\Wrapper;

use Maisner\Calendar\Event;

interface ICalendarWrapper {

	public function getEvent(string $id): Event;

	public function insertEvent(Event $event): void;

	public function updateEvent(Event $event): void;

	public function removeEvent(Event $event): void;
}