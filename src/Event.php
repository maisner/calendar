<?php

namespace Maisner\Calendar;

class Event {

	/** @var \DateTimeImmutable */
	private $startDatetime;

	/** @var \DateTimeImmutable */
	private $endDatetime;

	/** @var string */
	private $name;

	/** @var null|string */
	private $description;

	public function __construct(
		\DateTimeImmutable $startDatetime,
		\DateTimeImmutable $endDatetime,
		string $name,
		?string $description
	) {
		$this->startDatetime = $startDatetime;
		$this->endDatetime = $endDatetime;
		$this->name = $name;
		$this->description = $description;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getStartDatetime(): \DateTimeImmutable {
		return $this->startDatetime;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getEndDatetime(): \DateTimeImmutable {
		return $this->endDatetime;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return null|string
	 */
	public function getDescription(): ?string {
		return $this->description;
	}
}