<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\parameter;

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandData;

class ParameterOverride {

	public function __construct() {
	}

	public function doOverride(AvailableCommandsPacket $packet, NetworkSession $target) {
		foreach ($packet->commandData as $name => $commandData) {
			$this->overrideParameter($commandData);
		}
	}

	public function overrideParameter(CommandData $commandData): bool {
		$parameters = Parameter::getInstance()->get($commandData->getName());
		if ($parameters !== null) {
			$commandData->overloads = $parameters; #大丈夫かな

			return true;
		}

		return false;
	}
}
