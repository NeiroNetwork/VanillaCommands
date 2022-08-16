<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands;

use NeiroNetwork\VanillaCommands\parameter\ParameterOverride;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener, $this);
	}
}
