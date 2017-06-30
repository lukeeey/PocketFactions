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

use TheDiamondYT\PocketFactions\entity\IMember;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\util\RoleUtil;

class CommandPromote extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "promote", $plugin->translate("commands.promote.description"));
		$this->addRequiredArgument("player");
	}

	public function getRequirements(): array {
		return [
			"player",
			"leader"
		];
	}

	public function perform(IMember $fme, array $args) {
		$target = $this->plugin->getPlayer($this->plugin->getServer()->getPlayer($args[0]));

		if($target === null) {
			$this->msg($this->plugin->translate("player.not-found"));
			return;
		}
		if($target->getFaction() !== $fme->getFaction()) {
			$this->msg($this->plugin->translate("player.not-in-faction"));
			return;
		}
		if($target->getRole() === ($highest = RoleUtil::getHighestRole()) && $highest !== RoleUtil::get("Leader")) {
			$this->msg($this->plugin->translate("commands.promote.highest-role", [$target->getName()]));
			return;
		}

		$role = RoleUtil::getNext($target->getRole());

		$fme->setRole($role);

		foreach($fme->getFaction()->getOnlinePlayers() as $player) {
			$player->sendMessage($this->plugin->translate("commands.promote.success", [
				$fme->describeTo($player, true),
				$target->describeTo($player),
				Role::getName($role)
			]));
		}
	}
}
