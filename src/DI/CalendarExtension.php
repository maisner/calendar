<?php

namespace Maisner\Calendar\DI;

use Maisner\Calendar\Calendar;
use Maisner\Calendar\Wrapper\ICalendarWrapper;
use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\DI\Statement;

class CalendarExtension extends CompilerExtension {

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('calendar'))
			->setFactory(Calendar::class);

		foreach ($this->config['wrappers'] as $index => $wrapper) {
			if ($wrapper instanceof Statement) {
				$this->registerWrapper($builder, $wrapper, (string)$index);
				continue;
			}

			if (\is_array($wrapper)) {
				foreach ($wrapper as $name => $item) {
					$this->registerWrapper($builder, $item, $name);
				}
			}
		}
	}

	protected function registerWrapper(ContainerBuilder $builder, Statement $statement, string $name): void {
		$builder->addDefinition($this->prefix('wrapper.' . $name))->setFactory($statement);
	}

	public function beforeCompile(): void {
		$builder = $this->getContainerBuilder();
		$calendarDefinition = $builder->getDefinitionByType(Calendar::class);

		/** @var ICalendarWrapper $wrapper */
		foreach ($builder->findByType(ICalendarWrapper::class) as $wrapper) {
			$calendarDefinition->addSetup('addWrapper', [$wrapper]);
		}
	}
}