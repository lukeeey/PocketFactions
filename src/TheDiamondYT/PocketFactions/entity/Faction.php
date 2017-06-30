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

use pocketmine\utils\UUID;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\util\RelationParticipator;
use TheDiamondYT\PocketFactions\util\RelationUtil;
use TheDiamondYT\PocketFactions\util\TextUtil;

/**
 * Represents a Faction.
 */
class Faction implements RelationParticipator {

	const WILDERNESS_ID = "wilderness";
	const WARZONE_ID = "warzone";

	/* @var FPlayer */
	private $leader;

	/* @var array */
	private $data;

	/* @var array */
	private $players = [];
	private $allies = [];

	/**
	 * Constructs a new Faction.
	 *
	 * @param string
	 * @param array
	 */
	public function __construct($id, array $data) {
		$this->id = $id;
		$this->data = $data;
	}

	/**
	 * Generates a random faction id.
	 *
	 * @return string
	 */
	public static function randomId() {
		return UUID::fromRandom()->toString();
	}

	public function describeTo(RelationParticipator $that, bool $ucfirst = false) {
		return RelationUtil::describeThatToMe($this, $that, $ucfirst);
	}

	/**
	 * Returns the current faction tag, or the tag for
	 * another players faction.
	 *
	 * @return string
	 */
	public function getTag(FPlayer $player = null) {
		if($player === null) {
			return $this->data["tag"];
		}
		return $this->getColorTo($player) . $this->data["tag"];
	}

	public function getColorTo(RelationParticipator $that) {
		return RelationUtil::getColorToMe($that, $this);
	}

	/**
	 * Set the tag for the current faction.
	 *
	 * @param string
	 */
	public function setTag(string $tag) {
		$this->data["tag"] = $tag;
		$this->update();
	}

	/**
	 * Updates the current faction information.
	 */
	public function update() {
		PF::getInstance()->getProvider()->updateFaction($this->data);
	}

	/**
	 * Set the description for the current faction.
	 *
	 * @param string
	 */
	public function setDescription(string $description) {
		$this->data["description"] = $description;
		$this->update();
	}

	/**
	 * Returns the description for the current faction.
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->data["description"] ?? "";
	}

	/**
	 * Returns the creation time of the faction.
	 *
	 * @return string
	 */
	public function getCreationTime(): string {
		return TextUtil::timeize($this->getRawCreationTime());
	}

	/**
	 * Returns the creation time of the faction as an integer.
	 *
	 * @return int
	 */
	public function getRawCreationTime(): int {
		return $this->data["createdAt"];
	}

	/**
	 * Set whether or not the faction is permanent.
	 *
	 * @param bool
	 */
	public function setPermanent(bool $value) {
		$this->data["flags"]["permanent"] = $value;
		$this->update();
	}

	/**
	 * Returns true if the current faction is permanent.
	 *
	 * @return bool
	 */
	public function isPermanent(): bool {
		return $this->data["flags"]["permanent"] ?? false;
	}

	/**
	 * Set whether or not a faction is joinable without invitation.
	 *
	 * @param bool
	 */
	public function setOpen(bool $value) {
		$this->data["flags"]["open"] = $value;
		$this->update();
	}

	/**
	 * Returns true if the current faction is open.
	 *
	 * @return bool
	 */
	public function isOpen(): bool {
		return $this->data["flags"]["open"] ?? false;
	}

	/**
	 * Returns every player in the current faction. Online, or not.
	 */
	public function getPlayers() {
		$players = [];
		foreach(PF::getInstance()->getProvider()->getPlayers() as $player) {
			if($player->getFaction() === $this) {
				$players[$player->getName()] = $player;
			}
		}
		return $players;
	}

	/**
	 * Add a player to the current faction.
	 *
	 * @param FPlayer
	 */
	public function addPlayer(FPlayer $player) {
		if($player->isLeader()) {
			$this->setLeader($player);
		}
		$this->players[$player->getName()] = $player;
	}

	/**
	 * Remove a player from the current faction.
	 *
	 * @param FPlayer
	 */
	public function removePlayer(FPlayer $player) {
		unset($this->players[$player->getName()]);
	}

	/**
	 * Send a message to everyone in the current faction.
	 *
	 * @param string
	 */
	public function sendMessage(string $text) {
		foreach($this->getOnlinePlayers() as $player) {
			$player->sendMessage($text);
		}
	}

	/**
	 * Returns all players online in the current faction.
	 *
	 * @return FPlayer[]
	 */
	public function getOnlinePlayers() {
		$players = [];
		foreach(PF::getInstance()->getProvider()->getOnlinePlayers() as $player) {
			if($player->getFaction() === $this && $player->isOnline()) {
				$players[$player->getName()] = $player;
			}
		}
		return $players;
	}

	/**
	 * Add an alliance with another faction.
	 *
	 * @param Faction
	 */
	public function addAlliance(Faction $faction) {
		$this->allies[$faction->getId()] = $faction;
	}

	/**
	 * Returns the id for the current faction.
	 *
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Remove an alliance with another faction.
	 *
	 * @param Faction
	 */
	public function removeAlliance(Faction $faction) {
		unset($this->allies[$faction->getId()]);
	}

	/**
	 * Returns true if in an alliance with the specified faction.
	 *
	 * @param  Faction
	 *
	 * @return bool
	 */
	public function isAllyWith(Faction $faction): bool {
		if(in_array($faction, $this->allies)) {
			return true;
		}
		return false;
	}

	/**
	 * Returns the leader of the current faction.
	 *
	 * @return FPlayer
	 */
	public function getLeader() {
		return $this->data["leader"];
	}

	/**
	 * Set the leader for the current factiom.
	 *
	 * @param FPlayer
	 */
	public function setLeader(FPlayer $player) {
		$this->data["leader"] = $player->getName();
		$this->update();
	}

	/**
	 * Returns true if the current faction is wilderness.
	 *
	 * @return bool
	 */
	public function isNone(): bool {
		return $this->getId() === self::WILDERNESS_ID;
	}

	/**
	 * @return bool
	 */
	public function isWarZone(): bool {
		return $this->getId() === self::WARZONE_ID;
	}

	/**
	 * Creates a new faction.
	 *
	 * @param bool $save
	 */
	public function create(bool $save = false) {
		$this->data["createdAt"] = time();
		PF::getInstance()->getProvider()->createFaction($this, $this->data, $save);
	}

	/**
	 * Disbands the current faction.
	 */
	public function disband() {
		PF::getInstance()->getProvider()->disbandFaction($this->getId());
	}
}
