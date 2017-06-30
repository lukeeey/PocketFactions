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
use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\IMember;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\Relation;
use TheDiamondYT\PocketFactions\util\RoleUtil;
use TheDiamondYT\PocketFactions\util\TextUtil;

class CommandCreate extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "create", $plugin->translate("commands.create.description"));
		$this->addRequiredArgument("faction name");
	}

	public function getRequirements(): array {
		return [
			"player"
		];
	}

	public function perform(IMember $fme, array $args) {
		if(count($args) >= 2 or count($args) === 0) {
			$this->msg(TF::RED . $this->getUsage());
			return;
		}
		if($fme->hasFaction() && !$fme->getFaction()->isPermanent()) {
			$this->msg($this->plugin->translate("player.has-faction"));
			return;
		}
		if($this->plugin->factionExists($args[0])) {
			$this->msg($this->plugin->translate("faction.tag.exists"));
			return;
		}
		if($this->plugin->playerExists($args[0])) {
			$this->msg($this->plugin->translate("faction.tag.exists-player"));
			return;
		}
		if(!TextUtil::alphanum($args[0])) {
			$this->msg($this->plugin->translate("faction.tag.invalid-chars"));
			return;
		}
		if(strlen($args[0]) > Configuration::getMaxTagLength()) {
			$this->msg($this->plugin->translate("faction.tag.too-long"));
			return;
		}
		if(strlen($args[0]) < Configuration::getMinTagLength()) {
			$this->msg($this->plugin->translate("faction.tag.too-short"));
			return;
		}

		//$ev = new FactionCreateEvent($this->plugin, $fme, $args[0]);
		//$ev->call();

		//if($ev->isCancelled())
		//    return;

		$faction = (new Faction($id = Faction::randomId(), [
			"tag" => $args[0],
			"id" => $id,
			"leader" => $fme->getName(),
			"description" => "Default faction description :("
		]));
		$faction->create();

		$fme->setRole(RoleUtil::get("Leader"));
		$fme->setFaction($faction);

		foreach($this->plugin->getProvider()->getOnlinePlayers() as $player) {
			$player->sendMessage($this->plugin->translate("commands.create.success", [
				$fme->describeTo($player, true),
				$fme->getColorTo($player) . $faction->getTag($player)
			]));
		}

		$this->msg($this->plugin->translate("commands.create.after", [($this->getCommand("desc"))->getUsage()]));
	}
}
