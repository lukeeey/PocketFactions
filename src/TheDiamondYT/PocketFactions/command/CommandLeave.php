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

class CommandLeave extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "leave", $plugin->translate("commands.leave.description"));
	}

	public function getRequirements(): array {
		return [
			"player",
			"faction"
		];
	}

	public function perform(IMember $fme, array $args) {
		/*if(!$fme->getFaction()->isPermanent() && $fme->isLeader()) {
			$this->msg($sender, $this->plugin->translate("player.give-leader"));
			return;
		}*/
		$fme->leaveFaction();
	}
}
