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

namespace TheDiamondYT\PocketFactions\entity;

use TheDiamondYT\PocketFactions\util\RelationParticipator;

interface IMember {

	/**
	 * Returns the players name.
	 *
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @return int
	 */
	public function getChatMode(): int;

	/**
	 * Sets the players chat mode.
	 *
	 * @param int
	 */
	public function setChatMode(int $mode);

	/**
	 * Return the players role prefix.
	 *
	 * @return string
	 */
	public function getPrefix(): string;

	/**
	 * Sets the players title in the faction.
	 *
	 * @param string
	 */
	public function setTitle(string $title);

	/**
	 * Return the players title.
	 *
	 * @return string
	 */
	public function getTitle(): string;

	/**
	 * Return the players prefix, name and title.
	 *
	 * @return string
	 */
	public function getNameAndTitle(): string;

	/**
	 * Return the players prefix and name.
	 *
	 * @return string
	 */
	public function getNameAndPrefix(): string;

	public function describeTo(RelationParticipator $that, bool $ucfirst = false);

	public function getColorTo(RelationParticipator $that);

	public function hasPermission(string $key): bool;

	/**
	 * Sends a message to the player.
	 *
	 * @param string
	 */
	public function sendMessage(string $text);

	/**
	 * Sets the players role in their faction
	 *
	 * @param int
	 */
	public function setRole(int $role);

	/**
	 * @return int
	 */
	public function getRole(): int;

	/**
	 * Toggle admin bypass mode.
	 *
	 * @param bool
	 */
	public function setAdminBypassing(bool $value);

	/**
	 * @return bool
	 */
	public function isAdminBypassing(): bool;

	/**
	 * Returns true if the player is leader.
	 *
	 * @return bool
	 */
	public function isLeader(): bool;

	/**
	 * Sets the players faction.
	 *
	 * @param Faction
	 */
	public function setFaction(Faction $faction);

	/**
	 * Leave the current faction.
	 */
	public function leaveFaction();

	/**
	 * Returns true if the player is in a faction.
	 *
	 * @return bool
	 */
	public function hasFaction(): bool;

	/**
	 * Returns the players current faction.
	 *
	 * @return Faction|null
	 */
	public function getFaction();
}
