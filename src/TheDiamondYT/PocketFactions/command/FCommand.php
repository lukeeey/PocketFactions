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

namespace TheDiamondYT\PocketFactions\command;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat as TF;
use TheDiamondYT\PocketFactions\entity\FConsole;
use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\util\TextUtil;

abstract class FCommand {

	/* @var PF */
	public $plugin;
	/* @var array */
	public $cfg;
	/* @var CommandSender */
	public $sender;
	/* @var IPlayer */
	public $fme;
	/* @var array */
	public $args = [];
	/* @var string */
	private $name, $desc, $cmdArgs;
	/* @var array */
	private $aliases = [];

	public function __construct(PF $plugin, $name, $desc, $aliases = []) {
		$this->plugin = $plugin;
		$this->name = $name;
		$this->desc = $desc;
		$this->aliases = $aliases;
		$this->cfg = $plugin->getConfig();
	}

	/**
	 * Returns the command name.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns the command description.
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->desc;
	}

	/**
	 * Returns the command name and arguments.
	 *
	 * @return string
	 */
	public function getUsage() {
		return TF::AQUA . "/f $this->name " . TF::DARK_AQUA . $this->cmdArgs;
	}

	/**
	 * Add a required argument for the command.
	 *
	 * @param string
	 */
	public function addRequiredArgument(string $arg) {
		$this->cmdArgs .= "<" . $arg . "> ";
	}

	/**
	 * Add an optional argument for the command.
	 *
	 * @param string
	 */
	public function addOptionalArgument(string $arg) {
		$this->cmdArgs .= "[" . $arg . "] ";
	}

	/**
	 * Returns the command aliases.
	 *
	 * @return array
	 */
	public function getAliases() {
		return $this->aliases;
	}

	/**
	 * Convienient method to get a faction command.
	 *
	 * @param string
	 *
	 * @return FCommand|null
	 */
	public function getCommand(string $label) {
		return $this->plugin->getCommandManager()->getCommand($label);
	}

	/**
	 * Sets up variables and does command checks, then performs the command.
	 *
	 * @param CommandSender
	 * @param IPlayer
	 * @param array
	 *
	 * @see FCommandManager
	 */
	public function execute(CommandSender $sender, $fme, array $args) {
		$this->sender = $sender;
		$this->args = $args;

		if($sender instanceof ConsoleCommandSender) {
			$this->fme = new FConsole($this->plugin);
		} else {
			$this->fme = $fme;
		}

		if(in_array("player", $this->getRequirements()) && $this->fme instanceof FConsole) {
			$this->msg($this->plugin->translate("commands.only-player"));
			return;
		}
		if(in_array("operator", $this->getRequirements()) && !$sender->isOp()) {
			// TODO
		}
		if(in_array("faction", $this->getRequirements()) && !$this->fme->hasFaction()) {
			$this->msg($this->plugin->translate("player.no-faction"));
			return;
		}
		if(in_array("leader", $this->getRequirements()) && !$fme->isLeader()) {
			$this->msg($this->plugin->translate("commands.only-leader"));
			return;
		}

		$this->perform($this->fme, $args);
	}

	/**
	 * Returns the command requirements.
	 *
	 * @return array
	 */
	public abstract function getRequirements(): array;

	/**
	 * Convienient method for sending a message to a player.
	 *
	 * @param string
	 */
	public function msg(string $text) {
		$this->sender->sendMessage(TextUtil::parse($text));
	}
}
