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

use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat as TF;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\util\RelationParticipator;
use TheDiamondYT\PocketFactions\util\RelationUtil;
use TheDiamondYT\PocketFactions\util\TextUtil;

/**
 * Represents a faction player, on the console.
 */
class FConsole implements IMember, RelationParticipator {

	/* @var ConsoleCommandSender */
	private $player;

	/* @var PF */
	private $plugin;

	public function __construct(PF $plugin) {
		$this->plugin = $plugin;
		$this->player = new ConsoleCommandSender();
	}

	/**
	 * @return int
	 */
	public function getChatMode(): int {
		return 0;
	}

	/**
	 * Sets the players chat mode.
	 *
	 * @param int
	 */
	public function setChatMode(int $mode) {
		throw new \LogicException("Cannot set chat mode for console player.");
	}

	/**
	 * Return the players role prefix.
	 *
	 * @return string
	 */
	public function getPrefix(): string {
		return "";
	}

	/**
	 * Sets the players title in the faction.
	 *
	 * @param string
	 */
	public function setTitle(string $title) {
		throw new \LogicException("Cannot set title for console player.");
	}

	/**
	 * Return the players title.
	 *
	 * @return string
	 */
	public function getTitle(): string {
		return "";
	}

	/**
	 * Return the players prefix, name and title.
	 *
	 * @return string
	 */
	public function getNameAndTitle(): string {
		return $this->getName();
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return "CONSOLE";
	}

	/**
	 * Return the players prefix and name.
	 *
	 * @return string
	 */
	public function getNameAndPrefix(): string {
		return $this->getName();
	}

	public function describeTo(RelationParticipator $that, bool $ucfirst = false) {
		return RelationUtil::describeThatToMe($this, $that, $ucfirst);
	}

	public function getColorTo(RelationParticipator $that) {
		return TF::WHITE;
	}

	public function hasPermission(string $key): bool {
		return true;
	}

	/**
	 * Sends a message to the player.
	 *
	 * @param string
	 */
	public function sendMessage(string $text) {
		$this->player->sendMessage(TextUtil::parse($text));
	}

	/**
	 * Sets the players role in their faction
	 *
	 * @param int
	 */
	public function setRole(int $role) {
		throw new \LogicException("Cannot set role for console player.");
	}

	/**
	 * @return int
	 */
	public function getRole(): int {
		return 0;
	}

	/**
	 * Toggle admin bypass mode.
	 *
	 * @param bool
	 */
	public function setAdminBypassing(bool $value) {
		throw new \LogicException("Cannot set admin bypass mode for console player.");
	}

	/**
	 * @return bool
	 */
	public function isAdminBypassing(): bool {
		return true;
	}

	/**
	 * Returns true if the player is leader.
	 *
	 * @return bool
	 */
	public function isLeader(): bool {
		return true;
	}

	/**
	 * Sets the players faction.
	 *
	 * @param Faction
	 */
	public function setFaction(Faction $faction) {
		throw new \LogicException("Cannot set faction for console player.");
	}

	/**
	 * Leave the current faction.
	 */
	public function leaveFaction() {

	}

	/**
	 * Returns true if the player is in a faction.
	 *
	 * @return bool
	 */
	public function hasFaction(): bool {
		return true;
	}

	/**
	 * @return Faction|null
	 */
	public function getFaction() {
		return $this->plugin->getFaction("Wilderness");
	}
}
