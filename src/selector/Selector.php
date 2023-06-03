<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\selector;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\Utils;

class Selector {
	use SingletonTrait {
		getInstance as Singleton__getInstance;
	}

	public static function getInstance(): self {
		return self::Singleton__getInstance();
	}

	const TYPE_ALL = 0; # @a 
	const TYPE_ENTITIES = 1; # @e
	const TYPE_NEAREST_PLAYER = 2; # @p
	const TYPE_RANDOM = 3; # @r
	const TYPE_SELF = 4; # @s

	public static function typeStr(int $type): string {
		return match ($type) {
			self::TYPE_ALL => "a",
			self::TYPE_ENTITIES => "e",
			self::TYPE_NEAREST_PLAYER => "p",
			self::TYPE_RANDOM => "r",
			self::TYPE_SELF => "s",
			default => ""
		};
	}

	/**
	 * @var \Closure[]
	 */
	protected array $list;

	public function __construct() {
		$this->list = [];

		$this->register(self::TYPE_ALL, function (CommandSender $sender, string $section): array {
			if ($sender instanceof Player) {
				return $sender->getWorld()->getPlayers();
			} else {
				return $sender->getServer()->getOnlinePlayers();
			}
		});

		$this->register(self::TYPE_NEAREST_PLAYER, function (CommandSender $sender, string $section): array {
			if ($sender instanceof Player) {
				$player = $sender->getWorld()->getNearestEntity($sender->getPosition(), 10000, Player::class);
				if ($player !== null) {
					return [$player];
				}
			}
			return [];
		});

		$this->register(self::TYPE_RANDOM, function (CommandSender $sender, string $section): array {
			if ($sender instanceof Player) {
				$players = $sender->getWorld()->getPlayers();
			} else {
				$players = $sender->getServer()->getOnlinePlayers();
			}

			if (count($players) > 0) {
				$player = $players[array_rand($players)];
				return [$player];
			}

			return [];
		});

		$this->register(self::TYPE_SELF, function (CommandSender $sender, string $section): array {
			if ($sender instanceof Player) {
				return [$sender];
			}

			return [];
		});
	}

	public function register(int $selectorType, \Closure $targets): void {
		Utils::validateCallableSignature(function (CommandSender $sender, string $section): array {
			return [];
		}, $targets);

		$this->list[$selectorType] = $targets;
	}

	public function getTargets(CommandSender $sender, string $section): array {
		$targets = [];
		foreach ($this->list as $type => $closure) {
			$startsWith = "@" . self::typeStr($type);
			if (str_starts_with($section, $startsWith)) {
				$targets = array_merge($targets, ($closure)($sender, $section));
			}
		}
		return $targets;
	}

	public function getSelectorCount(array $args): int {
		$c = 0;
		foreach ($args as $section) {
			if (str_starts_with($section, "@")) {
				++$c;
			}
		}

		return $c;
	}

	/**
	 * @return Player[][]
	 */
	public function getAll(CommandSender $sender, array $args): array {
		$list = [];
		foreach ($args as $section) {
			$targets = $this->getTargets($sender, $section);
			$list[] = $targets;
		}

		return $list;
	}
}
