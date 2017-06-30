<?php
/*
 *  _____           _        _   ______         _   _                 
 * |  __ \         | |      | | |  ____|       | | (_)                
 * | |__) |__   ___| | _____| |_| |__ __ _  ___| |_ _  ___  _ __  ___ 
 * |  ___/ _ \ / __| |/ / _ \ __|  __/ _` |/ __| __| |/ _ \| '_ \/ __|
 * | |  | (_) | (__|   <  __/ |_| | | (_| | (__| |_| | (_) | | | \__ \
 * |_|   \___/ \___|_|\_\___|\__|_|  \__,_|\___|\__|_|\___/|_| |_|___/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.     
 *
 * PocketFactions v1.0.1 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */

namespace TheDiamondYT\PocketFactions\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\entity\FPlayer;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\ChatMode;
use TheDiamondYT\PocketFactions\struct\Relation;

class FPlayerListener implements Listener {

	private $plugin;

	public function __construct(PF $plugin) {
		$this->plugin = $plugin;
	}

	public function onPlayerJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer();
		$provider = $this->plugin->getProvider();

		if(!$provider->playerExists($player)) {
			$provider->addNewPlayer($player);
		} else {
			$provider->addPlayer($player);
		}
		$provider->getPlayer($player->getName())->setOnline(true);
	}

	public function onPlayerQuit(PlayerQuitEvent $event) {
		$this->plugin->getProvider()->removePlayer($event->getPlayer());
	}

	public function onPlayerChat(PlayerChatEvent $event) {
		$player = $event->getPlayer();
		$fme = $this->plugin->getPlayer($player->getName());
		$faction = $fme->getFaction();

		switch($fme->getChatMode()) {
			case ChatMode::FACTION:
				$message = vsprintf(Configuration::getFactionChatFormat(), [
					$this->getName($fme),
					$event->getMessage()
				]);

				$faction->sendMessage($message);
				$event->setCancelled(true);
				break;
			case ChatMode::ALLY:
				$message = vsprintf(Configuration::getAllyChatFormat(), [
					$faction->getTag(),
					$this->getName($fme),
					$event->getMessage()
				]);

				$faction->sendMessage($message);
				$event->setCancelled(true);
				break;
		}
	}

	/**
	 * Returns the players name with their role prefix.
	 *
	 * @param  FPlayer $player
	 *
	 * @return string
	 */
	private function getName(FPlayer $player): string {
		return $player->getPrefix() . $player->getName();
	}
}
