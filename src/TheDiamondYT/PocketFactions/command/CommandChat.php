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

use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\entity\IMember;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\ChatMode;
use TheDiamondYT\PocketFactions\struct\Relation;

class CommandChat extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "chat", $plugin->translate("commands.chat.description"), ["c"]);
		$this->addRequiredArgument("mode");
	}

	public function getRequirements(): array {
		return [
			"player"
		];
	}

	public function perform(IMember $fme, array $args) {
		if(empty($args)) {
			$this->msg($this->getUsage());
			return;
		}

		switch($args[0]) {
			case "p":
			case "public":
				$fme->setChatMode(ChatMode::PUBLIC);
				$this->msg("Public chat mode.");
				break;
			case "f":
			case "faction":
				if(!Configuration::isFactionChatEnabled()) {
					$this->msg($this->plugin->translate("commands.chat.faction-disabled"));
					return;
				}
				$fme->setChatMode(ChatMode::FACTION);
				$this->msg("Faction only chat mode.");
				break;
			case "a":
			case "ally":
				if(!Configuration::isAllyChatEnabled()) {
					$this->msg($this->plugin->translate("commands.chat.ally-disabled"));
					return;
				}
				$fme->setChatMode(ChatMode::ALLY);
				$this->msg("Alliance only chat mode.");
				break;
			default:
				$this->msg($this->plugin->translate("commands.chat.fail"));
				return;
		}
	}
}
