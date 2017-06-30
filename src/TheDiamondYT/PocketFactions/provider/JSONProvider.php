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
use pocketmine\utils\Config;
use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\FPlayer;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\Role;

/**
 * TODO - CLEANUP
 */
class JSONProvider implements Provider {

	private $plugin;

	private $factions = [];
	private $players = [];

	private $factionData;
	private $playerData;

	public function __construct(PF $plugin) {
		$this->plugin = $plugin;

		@mkdir($plugin->getDataFolder() . "factions");
		@mkdir($plugin->getDataFolder() . "players");
	}

	public function save() {
		if($this->factionData !== null) {
			$this->factionData->save();
		}
		if($this->playerData !== null) {
			$this->playerData->save();
		}
	}

	public function loadFactions() {
		$directory = $this->plugin->getDataFolder() . "factions/";
		foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file => $factions) {
			if(pathinfo($file)["extension"] === "json") {
				$factions = json_decode(file_get_contents($factions), true);
				$faction = new Faction($factions["id"], $factions);
				$this->factions[$faction->getId()] = $faction;
			}
		}
	}

	public function loadPlayers() {
		$directory = $this->plugin->getDataFolder() . "players/";
		foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file => $players) {
			if(pathinfo($file)["extension"] === "json") {
				$players = json_decode(file_get_contents($players), true);
				$player = new FPlayer($this->plugin,
					$this->plugin->getServer()->getOfflinePlayer($players["name"]),
					$players
				);
				//$player->setFaction($this->getFactionById($players["faction"]["id"]));
				$this->players[$player->getName()] = $player;
			}
		}
	}

	public function getOnlinePlayers() {
		$players = [];
		foreach($this->players as $player) {
			if($player->isOnline()) {
				$players[$player->getName()] = $player;
			}
		}
		return $players;
	}

	public function getPlayers() {
		return $this->players;
	}

	public function getPlayer($player) {
		if(!$this->playerExists($player)) {
			return null;
		}
		foreach($this->players as $p) {
			if($player === $p->getName()) {
				return $p;
			}
		}
	}

	public function playerExists($player): bool {
		foreach($this->players as $p) {
			if($player === $p->getName()) {
				return true;
			}
		}
		return false;
	}

	public function addNewPlayer(Player $player, bool $save = true) {
		$this->playerData = new Config($this->getPlayerFile($player->getUniqueId()), Config::JSON);
		$this->playerData->setAll([
			"name" => $player->getName(),
			"displayName" => $player->getDisplayName(),
			"faction" => [
				"id" => Faction::WILDERNESS_ID,
				"role" => Role::get("Member"),
				"title" => ""
			]
		]);
		if($save) {
			$this->playerData->save();
		}
		$this->addPlayer($player);
	}

	private function getPlayerFile($id) {
		return $this->plugin->getDataFolder() . "players/" . $id . ".json";
	}

	public function addPlayer(Player $player) {
		$fplayer = new FPlayer($this->plugin,
			$player,
			(new Config($this->getPlayerFile($player->getUniqueId()),
				Config::JSON
			))->getAll());

		$this->players[$player->getName()] = $fplayer;
	}

	public function updatePlayer(array $data) {
		$this->playerData->setAll($data);
	}

	// TODO: make better

	public function removePlayer(Player $player) {
		unset($this->players[$player->getName()]);
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

	public function getFactionById(string $id) {
		foreach($this->factions as $facs) {
			if($facs->getId() === $id) {
				return $this->factions[$id];
			}
		}
	}

	public function getFactions() {
		return $this->factions;
	}

	public function createFaction(Faction $faction, array $data, bool $save = false) {
		$this->factionData = new Config($this->getFile($faction->getId()), Config::JSON);
		$this->factionData->setAll($data);

		if($save === true or Configuration::saveFactionOnCreate()) {
			$this->factionData->save();
		}
		$this->factions[$faction->getId()] = $faction;
	}

	private function getFile($id) {
		return $this->plugin->getDataFolder() . "factions/" . $id . ".json";
	}

	public function disbandFaction(string $id) {
		if(!file_exists($file = $this->getFile($id))) {
			return;
		}
		unlink($file);
		unset($this->factions[$id]);
	}

	public function updateFaction(array $data) {
		$this->factionData->setAll($data);
	}
}
