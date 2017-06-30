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
use TheDiamondYT\PocketFactions\entity\IMember;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\util\TextUtil;

class CommandHelp extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "help", $plugin->translate("commands.help.description"), ["h", "?"]);
		$this->addRequiredArgument("page");
	}

	public function getRequirements(): array {
		return [];
	}

	public function perform(IMember $fme, array $args) {
		if(count($args) === 0) {
			$page = 1;
		} elseif(is_numeric($args[0])) {
			$page = (int) array_shift($args);
			if($page <= 0) {
				$page = 1;
			}
		} else {
			return false;
		}
		$commands = [];
		foreach($this->plugin->getCommandManager()->getCommands() as $command)
			$commands[$command->getName()] = $command;

		ksort($commands, SORT_NATURAL | SORT_FLAG_CASE);
		$commands = array_chunk($commands, Configuration::getHelpPageLength());
		$page = (int) min(count($commands), $page);

		$this->msg(TextUtil::titleize($this->plugin->translate("commands.help.header", [$page, count($commands)])));
		foreach($commands[$page - 1] as $command)
			$this->msg($command->getUsage() . " " . TF::YELLOW . $command->getDescription());
	}
}
