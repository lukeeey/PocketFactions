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

namespace TheDiamondYT\PocketFactions\command;

use pocketmine\utils\TextFormat as TF;
use TheDiamondYT\PocketFactions\entity\IMember;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\Relation;
use TheDiamondYT\PocketFactions\util\TextUtil;

class CommandList extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "list", $plugin->translate("commands.list.description"));
		$this->addOptionalArgument("factionless");
	}

	public function getRequirements(): array {
		return [];
	}

	public function perform(IMember $fme, array $args) {
		$faction = $fme->getFaction();
		$factionless = [];
		$factions = [];

		$this->msg(TextUtil::titleize($this->plugin->translate("commands.list.header")));

		// Factionless players
		foreach($this->plugin->getProvider()->getOnlinePlayers() as $player) {
			if(!$player->hasFaction()) {
				$factionless[$player->getName()] = $player->getName();
			}
		}

		if(!empty($args) && !is_numeric($args[0])) {
			if(strtolower($args[0]) === "factionless") {
				$this->msg(TF::GOLD . "Factionless: " . count($factionless) . " online");
				$this->msg(TF::YELLOW . implode(", ", $factionless));
				return;
			}
		}

		// All factions
		foreach($this->plugin->getProvider()->getFactions() as $faction) {
			$factions[] = $faction;
		}

		if(count($args) === 0) {
			$page = 1;
		} elseif(is_numeric($args[1])) {
			$page = (int) $args[1];
		}

		ksort($factions, SORT_NATURAL | SORT_FLAG_CASE);

		$factions = array_chunk($factions, 5);

		$this->msg(TF::GOLD . "Factionless: " . count($factionless) . " online");

		foreach($factions[$page - 1] as $faction) {
			$this->msg(TF::GOLD . "{$faction->getTag()} " . TF::YELLOW . count($faction->getOnlinePlayers()));
		}
	}
}
