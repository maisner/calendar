<?php

namespace Maisner\Calendar\DI;

use Maisner\Calendar\Calendar;
use Maisner\Calendar\Service\ICalendarService;
use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\DI\Statement;

class CalendarExtension extends CompilerExtension {

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('calendar'))
			->setFactory(Calendar::class);

		foreach ($this->config['calendarServices'] as $index => $service) {
			if ($service instanceof Statement) {
				$this->registerCalendarService($builder, $service, (string)$index);
				continue;
			}

			if (\is_array($service)) {
				foreach ($service as $name => $item) {
					$this->registerCalendarService($builder, $item, $name);
				}
			}
		}
	}

	protected function registerCalendarService(ContainerBuilder $builder, Statement $statement, string $name): void {
		$builder->addDefinition($this->prefix('calendarService.' . $name))->setFactory($statement);
	}

	public function beforeCompile(): void {
		$builder = $this->getContainerBuilder();
		$calendarDefinition = $builder->getDefinitionByType(Calendar::class);

		/** @var ICalendarService $service */
		foreach ($builder->findByType(ICalendarService::class) as $service) {
			$calendarDefinition->addSetup('addService', [$service]);
		}
	}
}