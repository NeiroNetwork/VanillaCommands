<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands;

use NeiroNetwork\VanillaCommands\parameter\ParameterOverride;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener, $this);
	}

	protected function onLoad(): void {
		$operator = PermissionManager::getInstance()->getPermission(DefaultPermissionNames::GROUP_OPERATOR);
		$root = new Permission(PermissionNames::ALL, "VanillaCommands All");
		DefaultPermissions::registerPermission($root, [$operator]);

		$selector = new Permission(PermissionNames::SELECTOR, "VanillaCommands: Selector");
		DefaultPermissions::registerPermission($selector, [$root]);
	}
}
