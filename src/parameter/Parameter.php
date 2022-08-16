<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\parameter;

use pocketmine\command\defaults\VanillaCommand;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandData;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\utils\SingletonTrait;

class Parameter {
	use SingletonTrait {
		getInstance as Singleton__getInstance;
	}

	public static function getInstance(): self {
		return self::Singleton__getInstance();
	}

	/**
	 * @var array[][]
	 */
	protected array $list;

	public function __construct() {
		$this->list = [];

		$this->add("kill", [
			BasicParameters::TARGETS("target")
		]);
	}

	public function add(string $name, array $parameters): void {
		if (!isset($this->list[$name])) {
			$this->list[$name] = [];
		}

		$this->list[$name][] = $parameters;
	}

	/**
	 * @param string $name
	 * 
	 * @return CommandParameter[]|null
	 */
	public function get(string $name): ?array {
		return $this->list[$name] ?? null;
	}
}
