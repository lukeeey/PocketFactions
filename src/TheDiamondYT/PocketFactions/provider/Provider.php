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

interface Provider {

	public function save();

	public function loadFactions();

	public function loadPlayers();

	public function getOnlinePlayers();

	public function getPlayer($player);

	public function addNewPlayer(Player $player);

	public function addPlayer(Player $player);

	public function removePlayer(Player $player);

	public function getFaction(string $tag);

	public function createFaction(Faction $faction, array $data, bool $save = false);

	public function disbandFaction(string $id);

	public function updateFaction(array $data);

	public function factionExists(string $faction): bool;

	public function playerExists($player): bool;
}
