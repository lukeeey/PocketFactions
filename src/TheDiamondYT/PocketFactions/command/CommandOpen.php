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

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\entity\IMember;
use TheDiamondYT\PocketFactions\util\RoleUtil;

class CommandOpen extends FCommand {

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "open", $plugin->translate("commands.open.description"));
    }
    
    public function getRequirements(): array {
        return [
            "player",
            "leader"
        ];
    }

    public function perform(IMember $fme, array $args) {        
        $faction = $fme->getFaction();
        $open = $faction->isOpen() ? "closed" : "open";
        
        $faction->setOpen(!$faction->isOpen());
        
        foreach($faction->getOnlinePlayers() as $player) {
            $player->sendMessage($this->plugin->translate("commands.open.success", [
                $fme->describeTo($player, true),
                $open
            ]));
        }
    }
}