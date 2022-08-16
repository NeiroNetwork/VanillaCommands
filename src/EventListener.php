<?php

declare(strict_types=1);

namespace NeiroNetwork\VanillaCommands;

use NeiroNetwork\VanillaCommands\parameter\ParameterOverride;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class EventListener implements Listener {

	protected ParameterOverride $override;

	public function __construct() {
		$this->override = new ParameterOverride();
	}

	public function onDataPacketSend(DataPacketSendEvent $event) {
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
}
