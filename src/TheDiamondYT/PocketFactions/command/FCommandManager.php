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
use pocketmine\command\PluginCommand;
use TheDiamondYT\PocketFactions\PF;

class FCommandManager extends PluginCommand {

	/* @var PF */
	private $plugin;

	/* @var array */
	private $subCommands = [];
	private $aliasSubCommands = [];

	public function __construct(PF $plugin) {
		parent::__construct("factions", $plugin);
		$this->plugin = $plugin;
		$this->setAliases(["faction", "fac", "f"]);
		$this->setDescription($plugin->translate("commands.description"));
		$this->registerCommands();
	}

	// TODO: cleanup
	private function registerCommands() {
		$this->registerCommand(new CommandBypass($this->plugin));
		$this->registerCommand(new CommandChat($this->plugin));
		$this->registerCommand(new CommandCreate($this->plugin));
		$this->registerCommand(new CommandDescription($this->plugin));
		$this->registerCommand(new CommandDisband($this->plugin));
		$this->registerCommand(new CommandHelp($this->plugin));
		$this->registerCommand(new CommandLeader($this->plugin));
		$this->registerCommand(new CommandPromote($this->plugin));
		$this->registerCommand(new CommandShow($this->plugin));
		$this->registerCommand(new CommandOpen($this->plugin));
		$this->registerCommand(new CommandList($this->plugin));
		$this->registerCommand(new CommandSave($this->plugin));
		$this->registerCommand(new CommandTag($this->plugin));
		$this->registerCommand(new CommandTitle($this->plugin));
		//$this->registerCommand(new CommandReload($this->plugin));
		$this->registerCommand(new CommandVersion($this->plugin));
	}

	/**
	 * Registers a subcommand and its aliases.
	 *
	 * @param FCommand
	 */
	public function registerCommand(FCommand $command) {
		$this->subCommands[$command->getName()] = $command;
		if(!empty($command->getAliases())) {
			foreach($command->getAliases() as $alias)
				$this->aliasSubCommands[$alias] = $command;
		}
	}

	/**
	 * Handles executing of the faction command, and executes any subcommands.
	 *
	 * @param CommandSender
	 * @param string
	 * @param array
	 */
	public function execute(CommandSender $sender, $label, array $args) {
		if(count($args) > 0) {
			$subcommand = strtolower(array_shift($args));
			if(isset($this->subCommands[$subcommand])) {
				$command = $this->subCommands[$subcommand];
			} elseif(isset($this->aliasSubCommands[$subcommand])) {
				$command = $this->aliasSubCommands[$subcommand];
			} else {
				$sender->sendMessage($this->plugin->translate("commands.not-found", [$subcommand]));
				return true;
			}
			$command->execute($sender, $this->plugin->getPlayer($sender->getName()), $args);
		} else {
			// TODO: better solution
			$this->getCommand("help")->execute($sender, $this->plugin->getPlayer($sender->getName()), $args);
		}
	}

	/**
	 * Returns the specified faction command.
	 *
	 * @return FCommand
	 */
	public function getCommand(string $label) {
		return $this->subCommands[$label];
	}

	/**
	 * Returns all registered faction commands.
	 *
	 * @return FCommand[]
	 */
	public function getCommands() {
		return $this->subCommands;
	}
}     
