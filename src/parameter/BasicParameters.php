<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\parameter;

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\utils\CloningRegistryTrait;

class BasicParameters {
	#use CloningRegistryTrait;

	public static function TARGETS(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_TARGET, $flags, $optional);
	}
}
