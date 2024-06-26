<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\parameter;

use pocketmine\entity\effect\StringToEffectParser;
use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\item\ItemFactory;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\utils\CloningRegistryTrait;

class BasicParameters {
	#use CloningRegistryTrait;

	/**
	 * @var string[]
	 */
	protected static array $itemNames = [];

	/**
	 * @var string[]
	 */
	protected static array $enchantNames = [];

	/**
	 * @var string[]
	 */
	protected static array $effectNames = [];

	public static function init(): void {
		if (empty(self::$itemNames)) {
			$map = LegacyStringToItemParser::getInstance()->getMappings();
			self::$itemNames = array_filter(array_keys($map), function (string $item): bool {
				return !is_numeric($item);
			});
		}

		if (empty(self::$enchantNames)) {
			$map = StringToEnchantmentParser::getInstance()->getKnownAliases();
			self::$enchantNames = $map;
		}

		if (empty(self::$effectNames)) {
			$map = StringToEffectParser::getInstance()->getKnownAliases();
			self::$effectNames = $map;
		}
	}


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

	public static function item(string $name, int $flags = 1, bool $optional = false): CommandParameter {
		return self::enum($name, "item", self::$itemNames, $flags, $optional);
	}

	public static function message(string $paramName, int $flags = 0, bool $optional = false): CommandParameter {
		return CommandParameter::standard($paramName, AvailableCommandsPacket::ARG_TYPE_MESSAGE, $flags, $optional);
	}

	public static function enchantment(string $name, int $flags = 1, bool $optional = false): CommandParameter {
		return self::enum($name, "enchantment", self::$enchantNames, $flags, $optional);
	}

	public static function effect(string $name, int $flags = 1, bool $optional = false): CommandParameter {
		return self::enum($name, "effect", self::$effectNames, $flags, $optional);
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
