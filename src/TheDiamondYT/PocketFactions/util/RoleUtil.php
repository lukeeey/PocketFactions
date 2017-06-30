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

namespace TheDiamondYT\PocketFactions\util;

class RoleUtil {

	const UNKNOWN = -1;

	private static $roles = [];

	public static function init() {
		self::addRole(100, "Member");
		self::addRole(200, "Moderator");
		self::addRole(300, "Administrator");
		self::addRole(400, "Leader");
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
	 * @return int
	 */
	public static function get(string $name): int {
		foreach(self::$roles as $id => $role) {
			if(strtolower($role) === strtolower($name)) {
				return $id;
			}
		}
		return self::UNKNOWN;
	}

	/**
	 * Returns a role name from id.
	 *
	 * @param int $roleId
	 *
	 * @return string
	 */
	public static function getName(int $roleId): string {
		foreach(self::$roles as $id => $role) {
			if($roleId == $id) {
				return $role;
			}
		}
		return "Unknown";
	}

	/**
	 * @param int $roleId
	 *
	 * @return int
	 */
	public static function getNext(int $roleId): int {
		foreach(self::$roles as $id => $role) {
			// TODO
		}
		return $roleId;
	}

	/**
	 * Returns the highest registered role.
	 *
	 * @return int
	 */
	public static function getHighestRole(): int {
		return max(array_keys($this->roles));
	}

	/**
	 * Returns true if a role exists.
	 *
	 * @param int
	 *
	 * @return bool
	 */
	public static function exists($roleId): bool {
		foreach(self::$roles as $id => $role) {
			if($roleId === $role) {
				return true;
			}
		}
		return false;
	}
}
