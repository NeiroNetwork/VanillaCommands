<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\parameter;

use NeiroNetwork\VanillaCommands\PermissionNames;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandData;
use pocketmine\network\mcpe\protocol\types\command\CommandOverload;

class ParameterOverride {

	public function __construct() {
	}

	public function doOverride(AvailableCommandsPacket $packet, NetworkSession $target) : void{
		foreach ($packet->commandData as $name => $commandData) {
			$this->overrideParameter($commandData);
		}
	}

	public function overrideParameter(CommandData $commandData): bool {
		$parameters = Parameter::getInstance()->get($commandData->getName());
		if ($parameters !== null) {
			$commandData->overloads = array_map(fn($p) => new CommandOverload(false, $p), $parameters);

			return true;
		}

		return false;
	}
}
