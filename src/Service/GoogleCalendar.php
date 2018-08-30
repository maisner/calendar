<?php

namespace Maisner\Calendar\Service;

use DateTime;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Maisner\Calendar\Event;
use Maisner\Calendar\Exception\ServiceActionException;

class GoogleCalendar implements ICalendarService {

	/** @var string */
	protected $authFile;

	/** @var string */
	protected $googleCalendarId;

	/** @var Google_Service_Calendar */
	protected $googleService;

	public function __construct(string $authFile, string $googleCalendarId) {
		$this->authFile = $authFile;
		$this->googleCalendarId = $googleCalendarId;
	}

	public function getCalendarId(): string {
		return $this->googleCalendarId;
	}

	public static function getServiceName(): string {
		return 'Google Calendar';
	}

	public function getGoogleService(): Google_Service_Calendar {
		if ($this->googleService instanceof Google_Service_Calendar) {
			return $this->googleService;
		}

		$client = new Google_Client();
		//		$client->setApplicationName('Calendar name');
		$client->addScope(Google_Service_Calendar::CALENDAR);
		$client->setAuthConfig($this->authFile);
		$client->useApplicationDefaultCredentials();
		$this->googleService = new Google_Service_Calendar($client);

		return $this->googleService;
	}

	/**
	 * @param Event $event
	 * @return string
	 * @throws ServiceActionException
	 */
	public function insertEvent(Event $event): string {
		$params = [
			'summary' => $event->getName(),
			'start'   => [
				'dateTime' => $event->getStartDatetime()->format(DateTime::RFC3339),
				'timeZone' => $event->getStartDatetime()->getTimezone()->getName(),
			],
			'end'     => [
				'dateTime' => $event->getEndDatetime()->format(DateTime::RFC3339),
				'timeZone' => $event->getEndDatetime()->getTimezone()->getName(),
			]
		];

		if ($event->getDescription() !== NULL) {
			$params['description'] = $event->getDescription();
		}

		try {
			$googleEvent = new Google_Service_Calendar_Event($params);
			$googleEvent = $this->getGoogleService()->events->insert($this->googleCalendarId, $googleEvent);

			return (string)$googleEvent->getId();
		} catch (\Exception $e) {
			throw new ServiceActionException((string)$e);
		}
	}

	public function updateEvent(string $eventId, Event $event): string {
		$service = $this->getGoogleService();
		$googleEvent = $this->getEvent($eventId);

		$start = new Google_Service_Calendar_EventDateTime();
		$start->setDateTime($event->getStartDatetime()->format(DateTime::RFC3339));

		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime($event->getEndDatetime()->format(DateTime::RFC3339));

		$googleEvent->setSummary($event->getName());
		$googleEvent->setStart($start);
		$googleEvent->setEnd($end);

		if ($event->getDescription() !== NULL) {
			$googleEvent->setDescription($event->getDescription());
		}

		try {
			$resEvent = $service->events->update($this->googleCalendarId, $googleEvent->getId(), $googleEvent);

			return (string)$resEvent->getId();
		} catch (\Exception $e) {
			throw new ServiceActionException((string)$e);
		}
	}

	public function removeEvent(string $eventId): void {
		try {
			$this->getGoogleService()->events->delete($this->googleCalendarId, $eventId);
		} catch (\Exception $e) {
			throw new ServiceActionException((string)$e);
		}
	}

	/**
	 * @param string $eventId
	 * @return Google_Service_Calendar_Event
	 * @throws ServiceActionException
	 */
	public function getEvent(string $eventId): Google_Service_Calendar_Event {
		$service = $this->getGoogleService();

		try {
			return $service->events->get($this->googleCalendarId, $eventId);
		} catch (\Exception $e) {
			throw new ServiceActionException((string)$e);
		}
	}
}