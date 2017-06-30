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
namespace TheDiamondYT\PocketFactions\event;

use pocketmine\event\Cancellable;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\Player;
use TheDiamondYT\PocketFactions\PF;

class FactionCreateEvent extends PluginEvent implements Cancellable {

	private $creator;
	private $tag;

	public function __construct(PF $plugin, Player $creator, string $tag) {
		parent::__construct($plugin);
		$this->creator = $creator;
		$this->tag = $tag;
	}

	/**
	 * @return string
	 */
	public function getTag(): string {
		return $this->tag;
	}

	/**
	 * @param string
	 */
	public function setTag(string $tag) {
		$this->tag = $tag;
	}
}
