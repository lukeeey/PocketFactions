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
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\FPlayer;

class RelationUtil {

	const NEUTRAL = 0;
	const ALLY = 1;
	const ENEMY = 2;
	const FACTION = 3;

	public static function describeThatToMe(RelationParticipator $me, RelationParticipator $that, bool $ucfirst = false): string {
		if($myFaction = self::getFaction($me) === null) {
			return "error";
		}
		if($thatFaction = self::getFaction($that) === null) {
			return "error";
		}
		if($that instanceof Faction) {
			if($myFaction === $thatFaction) {
				$ret = "your faction";
			} else {
				$ret = $thatFaction->getTag();
			}
		} elseif($that instanceof FPlayer) {
			if($that === $me) {
				$ret = "you";
			} elseif($thatFaction === $myFaction) {
				$ret = $that->getNameAndTitle();
			} else {
				$ret = $that->getNameAndTag();
			}
		}

		if($ucfirst === true) {
			$ret = ucfirst($ret);
		}
		return " " . self::getColorToMe($that, $me) . $ret . TF::YELLOW;
	}

	public static function getFaction(RelationParticipator $object) {
		if($object instanceof Faction) {
			return $object;
		}
		if($object instanceof FPlayer) {
			if($object->hasFaction()) {
				return $object->getFaction();
			}
		}
		return null;
	}

	public static function getColorToMe(RelationParticipator $that, RelationParticipator $me): string {
		$thatFaction = self::getFaction($that);
		$myFaction = self::getFaction($me);

		if($thatFaction !== null) {
			if($thatFaction->getId() === Faction::WILDERNESS_ID) {
				return TF::DARK_GREEN;
			}
			if($thatFaction->getId() === Faction::WARZONE_ID) {
				return TF::DARK_RED;
			}
			if($thatFaction->isAllyWith($myFaction) === self::ALLY) {
				return TF::LIGHT_PURPLE;
			}
			if($thatFaction === $myFaction) {
				return TF::GREEN;
			} else {
				return TF::WHITE;
			}
		}
		return TF::WHITE;
	}
}
