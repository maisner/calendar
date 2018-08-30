<?php

namespace Maisner\Calendar;

use Maisner\Calendar\Exception\ServiceActionException;
use Maisner\Calendar\Result\ActionResults;
use Maisner\Calendar\Result\OneServiceActionResult;
use Maisner\Calendar\Service\ICalendarService;

class Calendar {

	/** @var array|ICalendarService[] */
	private $services = [];

	public function addService(ICalendarService $service): void {
		$this->services[$service->getServiceName()] = $service;
	}

	/**
	 * @param Event $event
	 * @return ActionResults
	 * @throws Exception\ActionIsNotAllowedException
	 */
	public function insertEvent(Event $event): ActionResults {
		$actionResult = new ActionResults(Action::INSERT_EVENT);

		foreach ($this->services as $service) {
			try {
				$eventId = $service->insertEvent($event);
			} catch (ServiceActionException $e) {
				$actionResult->addResult(
					OneServiceActionResult::createFailedResult($service->getServiceName(), $e->getMessage())
				);
				continue;
			}

			$actionResult->addResult(OneServiceActionResult::createSuccessResult($service->getServiceName(), $eventId));
		}

		return $actionResult;
	}

	/**
	 * @param EventIdsCollection $eventIds
	 * @param Event              $event
	 * @return ActionResults
	 * @throws Exception\ActionIsNotAllowedException
	 */
	public function updateEvent(EventIdsCollection $eventIds, Event $event): ActionResults {
		$actionResult = new ActionResults(Action::UPDATE_EVENT);

		foreach ($this->services as $service) {
			$eventId = $eventIds->getEventId($service->getServiceName());

			if ($eventId === NULL) {
				continue;
			}

			try {
				$service->updateEvent($eventId, $event);
			} catch (ServiceActionException $e) {
				$actionResult->addResult(
					OneServiceActionResult::createFailedResult($service->getServiceName(), $e->getMessage(), $eventId)
				);
				continue;
			}

			$actionResult->addResult(OneServiceActionResult::createSuccessResult($service->getServiceName(), $eventId));
		}

		return $actionResult;
	}

	/**
	 * @param EventIdsCollection $eventIds
	 * @return ActionResults
	 * @throws Exception\ActionIsNotAllowedException
	 */
	public function removeEvent(EventIdsCollection $eventIds): ActionResults {
		$actionResult = new ActionResults(Action::REMOVE_EVENT);

		foreach ($this->services as $service) {
			$eventId = $eventIds->getEventId($service->getServiceName());

			if ($eventId === NULL) {
				continue;
			}

			try {
				$service->removeEvent($eventId);
			} catch (ServiceActionException $e) {
				$actionResult->addResult(
					OneServiceActionResult::createFailedResult($service->getServiceName(), $e->getMessage(), $eventId)
				);
				continue;
			}

			$actionResult->addResult(OneServiceActionResult::createSuccessResult($service->getServiceName(), $eventId));
		}

		return $actionResult;
	}
}