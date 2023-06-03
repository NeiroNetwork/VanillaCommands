<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands;

use NeiroNetwork\VanillaCommands\parameter\ParameterOverride;
use NeiroNetwork\VanillaCommands\selector\handler\SelectorHandler;
use NeiroNetwork\VanillaCommands\selector\Selector;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\CommandEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\CommandRequestPacket;

class EventListener implements Listener {

	protected ParameterOverride $override;
	protected SelectorHandler $selectorHandler;

	public function __construct() {
		$this->override = new ParameterOverride();
		$this->selectorHandler = new SelectorHandler();
	}

	public function onDataPacketSend(DataPacketSendEvent $event) : void{
		$packets = $event->getPackets();
		$targets = $event->getTargets();

		foreach ($targets as $origin) {
			$player = $origin->getPlayer();
			foreach ($packets as $packet) {
				if ($packet instanceof AvailableCommandsPacket) {
					$this->override->doOverride($packet, $origin);
				}
			}
		}
	}

	public function onCommand(CommandEvent $event) : void{
		$message = $event->getCommand();
		$sender = $event->getSender();

		$args = explode(" ", $message);
		$commandName = $args[0];
		unset($args[0]);
		$args = array_values($args);

		$all = Selector::getInstance()->getAll($sender, $args);
		$success = $this->selectorHandler->handle($sender, $commandName, $args, $all);

		if ($success) $event->cancel();
	}
}
