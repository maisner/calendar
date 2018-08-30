<?php

namespace Maisner\Calendar\Result;

use Maisner\Calendar\Action;
use Maisner\Calendar\Exception\ActionIsNotAllowedException;

class ActionResults {

	/** @var string */
	private $action;

	/** @var array|OneServiceActionResult[] */
	private $results;

	public function __construct(string $action = Action::INSERT_EVENT) {
		if (!Action::validate($action)) {
			throw new ActionIsNotAllowedException(sprintf('Action "%s" is not allowed', $action));
		}

		$this->action = $action;
		$this->results = [];
	}

	public function getAction(): string {
		return $this->action;
	}

	public function addResult(OneServiceActionResult $result): void {
		$this->results[$result->getService()] = $result;
	}

	/**
	 * @return array|OneServiceActionResult[]
	 */
	public function getResults(): array {
		return $this->results;
	}

	public function getOneResultByService(string $service) {
		return $this->results[$service] ?? NULL;
	}

	public function isSuccess(): bool {
		foreach ($this->results as $result) {
			if (!$result->isSuccess()) {
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * @return array|string[]
	 */
	public function getErrorMessages(): array {
		$errors = [];

		foreach ($this->results as $result) {
			if ($result->isSuccess()) {
				continue;
			}

			$errors[] = $result->getMessage();
		}

		return $errors;
	}
}