<?php

namespace Maisner\Calendar;

class Action {

	public const INSERT_EVENT = 'insert_event';

	public const UPDATE_EVENT = 'update_event';

	public const REMOVE_EVENT = 'remove_event';

	private const ALLOWED_ACTIONS = [
		self::INSERT_EVENT,
		self::UPDATE_EVENT,
		self::REMOVE_EVENT
	];

	public static function validate(string $actionString): bool {
		return \in_array($actionString, self::ALLOWED_ACTIONS, TRUE);
	}
}