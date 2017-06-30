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

namespace TheDiamondYT\PocketFactions;

class Configuration {

	/** @var array */
	private static $data;
	private static $factionData;

	public static function init(array $data) {
		self::$data = $data;
		self::$factionData = $data["faction"];
	}

	/**
	 * Returns the language to be used in this plugin.
	 *
	 * @return string
	 */
	public static function getLanguage(): string {
		return self::$data["language"] ?? "en";
	}

	/**
	 * Returns the data provider used for saving faction and player data.
	 *
	 * @return string
	 */
	public static function getProvider(): string {
		return self::$data["provider"] ?? "json";
	}

	/**
	 * Returns whether or not to save faction data on creation.
	 *
	 * @return bool
	 */
	public static function saveFactionOnCreate(): bool {
		return self::$factionData["saveOnCreate"] ?? true;
	}

	/**
	 * Returns the amount of entries per page of the faction help command.
	 *
	 * @return int
	 */
	public static function getHelpPageLength(): int {
		return self::$data["helpPageLength"] ?? 5;
	}

	/**
	 * Returns the maximum allowed length of a faction tag.
	 *
	 * @return int
	 */
	public static function getMaxTagLength(): int {
		return self::$factionData["tag"]["max-length"] ?? 10;
	}

	/**
	 * Returns the minimum allowed length of a faction tag.
	 *
	 * @return int
	 */
	public static function getMinTagLength(): int {
		return self::$factionData["tag"]["min-length"] ?? 3;
	}

	/**
	 * @return int
	 */
	public static function getHeaderLength(): int {
		return self::$data["headerLength"] ?? 7;
	}

	/**
	 * @return bool
	 */
	public static function isSameFactionPvPAllowed(): bool {
		return self::$factionData["pvp"]["same-faction"] ?? true;
	}

	/**
	 * @return bool
	 */
	public static function isFactionChatEnabled(): bool {
		return self::$factionData["chat-format"]["faction"]["enable"] ?? true;
	}

	/**
	 * @return string
	 */
	public static function getFactionChatFormat(): string {
		return self::$factionData["chat-format"]["faction"]["format"];
	}

	/**
	 * @return bool
	 */
	public static function isAllyChatEnabled(): bool {
		return self::$factionData["chat-format"]["ally"]["enable"] ?? true;
	}

	/**
	 * @return string
	 */
	public static function getAllyChatFormat(): string {
		return self::$factionData["chat-format"]["ally"]["format"];
	}
}
