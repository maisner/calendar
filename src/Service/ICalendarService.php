<?php

namespace Maisner\Calendar\Service;

use Maisner\Calendar\Event;
use Maisner\Calendar\Exception\ServiceActionException;

interface ICalendarService {

	public function getServiceName(): string;

	//	public function getEvent(string $id): Event;

	/**
	 * @param Event $event
	 * @throws ServiceActionException
	 * @return string event id
	 */
	public function insertEvent(Event $event): string;

	/**
	 * @param string $eventId
	 * @param Event  $event
	 * @throws ServiceActionException
	 * @return string event id
	 */
	public function updateEvent(string $eventId, Event $event): string;

	/**
	 * @param string $eventId
	 * @throws ServiceActionException
	 */
	public function removeEvent(string $eventId): void;
}