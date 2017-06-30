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

use pocketmine\utils\TextFormat as TF;
use TheDiamondYT\PocketFactions\Configuration;

class TextUtil {

	/**
	 * Creates a title header.
	 *
	 * @param string
	 *
	 * @return string
	 */
	public static function titleize(string $text): string {
		$length = Configuration::getHeaderLength();
		return TF::GOLD . str_repeat("_", $length) . ".[ " . TF::WHITE . $text . TF::RESET . TF::GOLD . " ]." . str_repeat("_", $length);
	}

	/**
	 * Returns a time as a string.
	 * Credit: BlockHorizons/FactionsPE
	 *
	 * @param int
	 *
	 * @return string
	 */
	public static function timeize(int $time): string {
		$periods = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
		$lengths = ["60", "60", "24", "7", "4.35", "12", "10"];

		$difference = time() - $time;

		for($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
			$difference /= $lengths[$i];
		}

		$difference = round($difference);

		if($difference !== 1) {
			$periods[$i] .= "s";
		}
		return TF::LIGHT_PURPLE . $difference . TF::AQUA . " " . $periods[$i] . " ago";
	}

	/**
	 * Check if a string contains alphanumeric characters.
	 *
	 * @param string
	 *
	 * @return bool
	 */
	public static function alphanum(string $text) {
		if(function_exists("ctype_alnum")) {
			return ctype_alnum($text);
		}
		return preg_match("/^[a-z0-9]+$/i", $text) > 0;
	}

	/**
	 * Replaces colour codes.
	 *
	 * @param string
	 *
	 * @return string
	 */
	public static function parse(string $text): string {
		$colours = [
			"<i>" => TF::YELLOW, //info
			"<info>" => TF::YELLOW,
			"<e>" => TF::RED, //error
			"<error>" => TF::RED,
			"<h>" => TF::LIGHT_PURPLE, //highlight
			"<highlight" => TF::LIGHT_PURPLE
		];

		foreach($colours as $code => $colour) {
			$text = str_replace($code, $colour, $text);
		}
		return $text;
	}
}
