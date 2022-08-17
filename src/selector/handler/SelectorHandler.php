<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands\selector\handler;

use NeiroNetwork\VanillaCommands\selector\Selector;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\player\Player;

class SelectorHandler {

	public function __construct() {
	}

	/**
	 * @param Player[][] $all
	 * 
	 * @return void
	 */
	public function handle(CommandSender $sender, string $commandName, array $args, array $all): bool {
		$base = $commandName;
		$argCount = count($args);
		$allCount = count($all);
		if ($allCount !== $argCount) {
			return false;
			#exception
		}

		$selectorCount = Selector::getInstance()->getSelectorCount($args);
		if ($selectorCount > 2) {
			return false;
		}

		$commands = $this->solveSection($base, $args, $all);
		foreach ($commands as $line) {
			#echo $line . "\n";
			$sender->getServer()->dispatchCommand($sender, $line, true);
		}


		return count($commands) > 0;
	}

	/**
	 * @param string $base
	 * @param string[] $args
	 * @param Player[][] $all
	 * @param int $startIndex
	 * 
	 * @return string[]
	 */
	protected function solveSection(string $base, array $args, array $all, int $startIndex = 0, int $count = 0): array {
		$argCount = count($args);
		$commands = [];

		if ($startIndex >= $argCount) {
			return [$base . " " . implode(" ", $args)];
		}

		for ($i = $startIndex; $i < $argCount; $i++) {
			$targets = $all[$i] ?? [];
			if (count($targets) > 0) {
				foreach ($targets as $target) {
					$args[$i] = $target->getName();
					$commandLine = $this->solveSection($base, $args, $all, $i + 1, $count++);
					$commands = array_merge($commands, $commandLine);
				}

				break;
			}

			if ($i === $argCount - 1) {
				return [$base . " " . implode(" ", $args)];
			}
		}

		return $commands;
	}
}
