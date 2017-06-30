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

namespace TheDiamondYT\PocketFactions\provider;

use pocketmine\Player;
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\FPlayer;
use TheDiamondYT\PocketFactions\PF;

class SQLiteProvider implements Provider {

	private $plugin;

	private $factions = [];
	private $players = [];

	private $db;

	public function __construct(PF $plugin) {
		$this->plugin = $plugin;
	}

	public function save() {

	}

	public function loadFactions() {

	}

	public function loadPlayers() {

	}

	public function getOnlinePlayers() {
		return $this->players;
	}

	public function getPlayer($player) {
		if($this->playerExists($player)) {
			return $this->players[$player];
		}

		return null;
	}

	public function playerExists($player): bool {
		/*foreach($this->fplayers as $player) {
			if($player->getName() === $name)
				return true;
		}*/
		return false;
	}

	public function addPlayer(Player $player) {
		$fplayer = new FPlayer($this->plugin, $player);

		$this->players[$player->getName()] = $fplayer;
		$this->players[$player] = $fplayer;
	}

	public function removePlayer(Player $player) {
		unset($this->players[$player->getName()]);
		unset($this->players[$player]);
	}

	public function getFaction(string $tag) {
		if(!$this->factionExists($tag)) {
			return null;
		}

		foreach($this->factions as $facs) {
			if($facs->getTag() === $tag) {
				return $this->factions[$facs->getId()];
			}
		}
	}

	public function factionExists(string $faction): bool {
		foreach($this->factions as $facs) {
			if($facs->getTag() === $faction or $facs->getId() === $faction) {
				return true;
			}
		}
		return false;
	}

	public function createFaction(Faction $faction, array $data, bool $save = false) {
		$this->factions[$faction->getId()] = $faction;
	}

	public function disbandFaction(string $id) {
		unset($this->factions[$id]);
	}

	public function updateFaction(array $data) {

	}
}
