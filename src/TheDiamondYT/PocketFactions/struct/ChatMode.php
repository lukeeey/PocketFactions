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

namespace TheDiamondYT\PocketFactions\struct;

class ChatMode {

	const PUBLIC = 0;
	const FACTION = 1;
	const ALLY = 2;

	private static $roles = [];

	public static function init() {
		self::addMode(0, "Public");
		self::addMode(1, "Faction");
		self::addMode(2, "Ally");
	}

	/**
	 * Creates a new faction chat mode.
	 *
	 * @param int
	 * @param string
	 */
	public static function addMode(int $id, string $name) {
		self::$chatModes[$id] = $name;
	}

	public static function get(string $name) {

	}

	/**
	 * Returns a faction chat mode as a string
	 *
	 * @param int
	 *
	 * @return string
	 */
	public static function byName(int $chat): string {
		switch($chat) {
			case ChatMode::PUBLIC:
				return "public";
			case ChatMode::FACTION:
				return "faction";
			case ChatMode::ALLY:
				return "ally";
			default:
				return "unknown";
		}
	}
}
