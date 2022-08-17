<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\parameter;

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\utils\CloningRegistryTrait;

class BasicParameters {
	#use CloningRegistryTrait;



	public static function targets(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_TARGET, $flags, $optional);
	}

	public static function int(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_INT, $flags, $optional);
	}

	public static function float(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_FLOAT, $flags, $optional);
	}

	public static function position(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_POSITION, $flags, $optional);
	}

	public static function string(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_STRING, $flags, $optional);
	}

	public static function item(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_STRING, $flags, $optional);
		# Item がない...!?
	}

	public static function message(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_MESSAGE, $flags, $optional);
	}

	public static function merge(CommandParameter $param, int $type): CommandParameter {
		$param->paramType |= $type;
		return $param;
	}

	public static function enum(string $name, string $enumName, ?array $enumValues = null, int $flags = 1, bool $optional = false) {
		if ($enumValues === null) {
			$enumValues = [$enumName];
		}
		return CommandParameter::enum($name, new CommandEnum($enumName, $enumValues), $flags, $optional);
	}



	public static function json(string $name, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($name, AvailableCommandsPacket::ARG_TYPE_JSON, $flags, $optional);
	}
}
