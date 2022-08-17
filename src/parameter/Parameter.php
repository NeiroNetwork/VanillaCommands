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
			BasicParameters::targets("target", optional: true)
		]);

		$this->add("clear", [
			BasicParameters::targets("player", optional: true),
			BasicParameters::item("itemName", optional: true),
			BasicParameters::int("data", optional: true),
			BasicParameters::int("maxCount", optional: true)
		]);

		$this->add("kick", [
			BasicParameters::targets("name"),
			BasicParameters::message("reason", optional: true)
		]);

		$this->add("time", [
			BasicParameters::enum("add", "add"),
			BasicParameters::int("amount")
		]);

		$this->add("time", [
			BasicParameters::enum("set", "set"),
			BasicParameters::merge(BasicParameters::string("time"), AvailableCommandsPacket::ARG_TYPE_INT)
		]);

		$this->add("time", [
			BasicParameters::enum("query", "query")
		]);

		$this->add("time", [
			BasicParameters::enum("start", "start")
		]);

		$this->add("time", [
			BasicParameters::enum("stop", "stop")
		]);

		$this->add("enchant", [
			BasicParameters::targets("player"),
			BasicParameters::int("enchantmentId"),
			BasicParameters::int("level", optional: true)
		]);

		$this->add("enchant", [
			BasicParameters::targets("player"),
			BasicParameters::string("enchantmentName"),
			BasicParameters::int("level", optional: true)
		]);

		$this->add("tp", [
			BasicParameters::targets("victim"),
			BasicParameters::targets("destination")
		]);

		$this->add("tp", [
			BasicParameters::targets("victim"),
			BasicParameters::position("destination"),
			BasicParameters::float("yRot", optional: true),
			BasicParameters::float("xRot", optional: true)
		]);

		$this->add("tp", [
			BasicParameters::targets("destination")
		]);

		$this->add("tp", [
			BasicParameters::position("destination"),
			BasicParameters::float("yRot", optional: true),
			BasicParameters::float("xRot", optional: true)
		]);

		$this->add("gamemode", [
			BasicParameters::string("gamemode"),
			BasicParameters::targets("player", optional: true)
		]);

		$this->add("give", [
			BasicParameters::targets("player"),
			BasicParameters::string("item : data(optional)"),
			BasicParameters::int("amount", optional: true),
			BasicParameters::json("nbt", optional: true)
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
	 * @return CommandParameter[][]|null
	 */
	public function get(string $name): ?array {
		return $this->list[$name] ?? null;
	}
}
