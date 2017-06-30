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

class Role {

	const UNKNOWN = -1;

	private static $roles = [];

	public static function init() {
		self::addRole(0, "Member");
		self::addRole(1, "Moderator");
		self::addRole(2, "Administrator");
		self::addRole(3, "Leader");
	}

	/**
	 * Creates a new faction role.
	 *
	 * @param int
	 * @param string
	 */
	public static function addRole(int $id, string $name) {
		self::$roles[$id] = $name;
	}

	/**
	 * Returns a role from a name.
	 *
	 * @param string
	 *
	 * @return int|null
	 */
	public static function get(string $name) {
		foreach(self::$roles as $id => $role) {
			if(strtolower($role) === strtolower($name)) {
				return $id;
			}
		}
		return null;
	}

	/**
	 * Returns true if a role exists.
	 *
	 * @param string|int
	 *
	 * @return bool
	 */
	public static function exists($role): bool {
		foreach(self::$roles as $id => $role) {
			if(is_int($role) && $id === $role) {
				return true;
			} elseif(strtolower($role) === strtolower($name)) {
				return true;
			}
		}
		return false;
	}
}
