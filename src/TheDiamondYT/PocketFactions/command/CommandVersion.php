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
use TheDiamondYT\PocketFactions\util\TextUtil;

/**
 * How to easily edit this plugin, and give yourself credit while
 * still keeping credit for me.
 *
 *   1. Edit the `plugin.yml` and add `authors: ["YourName"]`
 *   2. Edit the `plugin.yml` and change `website` to your GitHub repo
 *   3. Done!
 *
 * Now you have credit for modifications, and i retain credit for the original plugin.
 */
class CommandVersion extends FCommand {

	public function __construct(PF $plugin) {
		parent::__construct($plugin, "version", $plugin->translate("commands.version.description"), ["ver", "v"]);
	}

	public function getRequirements(): array {
		return [];
	}

	public function perform(IMember $fme, array $args) {
		$this->msg(TextUtil::titleize($this->plugin->translate("commands.version.header")));
		$this->msg($this->plugin->translate("commands.version.name", [$this->plugin->getDescription()->getName()]));
		$this->msg($this->plugin->translate("commands.version.version", [$this->plugin->getDescription()->getVersion()]));
		$this->msg($this->plugin->translate("commands.version.website", [$this->plugin->getDescription()->getWebsite()]));
		$this->msg("<h>Author: " . TF::AQUA . "TheDiamondYT");

		if(count($authors = $this->plugin->getDescription()->getAuthors()) > 1) {
			$list = "";
			foreach($authors as $author) {
				if($author !== "TheDiamondYT") {
					$list .= "$author ";
				}
			}
			$this->msg("");
			$this->msg($this->plugin->translate("commands.version.modified", [$list]));
		}
	}
}
