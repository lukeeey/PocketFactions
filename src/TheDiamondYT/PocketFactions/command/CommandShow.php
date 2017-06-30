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

class CommandShow extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "show", $plugin->translate("commands.show.description"), ["who"]);
		$this->addOptionalArgument("faction");
	}

	public function getRequirements(): array {
		return [];
	}

	public function perform(IMember $fme, array $args) {
		$faction = $fme->getFaction();
		if(!empty($args)) {
			$faction = $this->plugin->getFaction($args[0]); // check for faction
			if($faction === null) {
				$p = $this->plugin->getPlayer($args[0]); // check for player
				if($p === null) {
					$faction = $fme->getFaction();  // just return our faction if not found
				} else {
					$faction = $p->getFaction(); // or return the players faction
				}
			}
		}
		$this->msg(TextUtil::titleize($this->plugin->translate("commands.show.header", [$fme->getColorTo($faction) . $faction->getTag()])));

		$this->addLine("Description", $faction->getDescription());
		$this->addLine("Created", $faction->getCreationTime());
		$this->addLine("Open", $faction->isOpen() ? TF::GREEN . "Yes" . "<i>, no invitation needed" : TF::RED . "No" . "<i>, invitation is required");

		if(!empty($onlinePlayers = $faction->getOnlinePlayers())) {
			$members = ""; // TODO: tidy up
			foreach($onlinePlayers as $online) {
				$members .= $online->getName() . ", ";
			}
			$this->addLine("Online", $members);
		}
	}

	private function addLine(string $key, string $value) {
		$this->msg(TF::GOLD . "$key: " . TF::YELLOW . $value);
	}
}
