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

		BasicParameters::init();

		$this->add("kill", [
			BasicParameters::targets("target", optional: true)
		]);

		$this->add("clear", [
			BasicParameters::targets("player", optional: true),
			BasicParameters::item("itemName", "item", optional: true),
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
			BasicParameters::enum("time", "time", ["day", "noon", "sunset", "night", "midnight", "sunrise"])
		]);

		$this->add("time", [
			BasicParameters::enum("set", "set"),
			BasicParameters::int("time")
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
			BasicParameters::string("gamemodeName"),
			BasicParameters::targets("player", optional: true)
		]);

		$this->add("gamemode", [
			BasicParameters::int("gamemode"),
			BasicParameters::targets("player", optional: true)
		]);

		$this->add("give", [
			BasicParameters::targets("player"),
			BasicParameters::item("item : data(optional)", "item"),
			BasicParameters::int("amount", optional: true),
			BasicParameters::json("nbt", optional: true)
		]);

		$this->add("effect", [
			BasicParameters::targets("player"),
			BasicParameters::string("effectName"),
			BasicParameters::float("duration", optional: true),
			BasicParameters::int("amplifier", optional: true),
			BasicParameters::string("showParticles", optional: true)
		]);

		$this->add("whitelist", [
			BasicParameters::enum("add", "add"),
			BasicParameters::string("playerName")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("add", "add"),
			BasicParameters::targets("playerName")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("remove", "remove"),
			BasicParameters::string("playerName")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("remove", "remove"),
			BasicParameters::targets("playerName")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("on", "on")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("off", "off")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("reload", "reload")
		]);

		$this->add("whitelist", [
			BasicParameters::enum("list", "list")
		]);

		$this->add("transferserver", [
			BasicParameters::string("server"),
			BasicParameters::int("port", optional: true)
		]);

		$this->add("title", [
			BasicParameters::targets("player"),
			BasicParameters::enum("clear", "clear")
		]);

		$this->add("title", [
			BasicParameters::targets("player"),
			BasicParameters::enum("reset", "reset")
		]);

		$this->add("title", [
			BasicParameters::targets("player"),
			BasicParameters::enum("title", "title"),
			BasicParameters::message("message")
		]);

		$this->add("title", [
			BasicParameters::targets("player"),
			BasicParameters::enum("subtitle", "subtitle"),
			BasicParameters::message("message")
		]);

		$this->add("title", [
			BasicParameters::targets("player"),
			BasicParameters::enum("actionbar", "actionbar"),
			BasicParameters::message("message")
		]);

		$this->add("title", [
			BasicParameters::targets("player"),
			BasicParameters::enum("times", "times"),
			BasicParameters::int("fadeIn"),
			BasicParameters::int("length"),
			BasicParameters::int("fadeOut")
		]);

		$this->add("tell", [
			BasicParameters::targets("player"),
			BasicParameters::message("message")
		]);

		$this->add("timings", [
			BasicParameters::enum("reset", "reset")
		]);

		$this->add("timings", [
			BasicParameters::enum("report", "report")
		]);

		$this->add("timings", [
			BasicParameters::enum("on", "on")
		]);

		$this->add("timings", [
			BasicParameters::enum("off", "off")
		]);

		$this->add("timings", [
			BasicParameters::enum("paste", "paste")
		]);

		$this->add("spawnpoint", [
			BasicParameters::targets("player", optional: true),
			BasicParameters::position("position", optional: true)
		]);

		$this->add("setworldspawn", [
			BasicParameters::position("position", optional: true)
		]);

		$this->add("say", [
			BasicParameters::message("message")
		]);

		$this->add("particle", [
			BasicParameters::string("particleName"),
			BasicParameters::position("position"),
			BasicParameters::position("size"),
			BasicParameters::int("amount", optional: true),
			BasicParameters::int("data", optional: true)
		]);

		$this->add("pardon", [
			BasicParameters::string("playerName")
		]);

		$this->add("pardon-ip", [
			BasicParameters::string("address")
		]);

		$this->add("op", [
			BasicParameters::targets("playerName")
		]);

		$this->add("op", [
			BasicParameters::string("playerName")
		]);

		$this->add("me", [
			BasicParameters::message("action")
		]);

		$this->add("difficulty", [
			BasicParameters::string("difficultyName")
		]);

		$this->add("difficulty", [
			BasicParameters::int("difficulty")
		]);

		$this->add("deop", [
			BasicParameters::targets("playerName")
		]);

		$this->add("deop", [
			BasicParameters::string("playerName")
		]);

		$this->add("defaultgamemode", [
			BasicParameters::string("gamemodeName")
		]);

		$this->add("defaultgamemode", [
			BasicParameters::int("gamemode")
		]);

		$this->add("ban", [
			BasicParameters::targets("victim"),
			BasicParameters::message("reason", optional: true)
		]);

		$this->add("ban", [
			BasicParameters::string("victimName"),
			BasicParameters::message("reason", optional: true)
		]);

		$this->add("ban-ip", [
			BasicParameters::string("address"),
			BasicParameters::message("reason", optional: true)
		]);

		$this->add("banlist", [
			BasicParameters::enum("ips", "ips", optional: true)
		]);

		$this->add("banlist", [
			BasicParameters::enum("players", "players", optional: true)
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
