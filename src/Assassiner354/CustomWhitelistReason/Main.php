<?php #Plugin by Assassiner354

/**
 * Copyright 2018 Assassiner354
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
 
namespace Assassiner354\CustomWhitelistReason;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase implements Listener {
	
	public function onEnable(){
        $this->getLogger()->info("Custom Whitelist Reason enabled by Assassiner354");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }    
    public function onPreLogin(PlayerPreLoginEvent $event) { //TODO! Fix the internal server error when a unwhitelisted player joins!
		$cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$reason = $cfg->get("whitelist.reason");
	    	
		$player = $event->getPlayer();
		$name = $player->getName();
	    
		
		if(!$player->isWhitelisted($name)) {
			$whitelistedMessage = str_replace(["{reason}", "{line}", "&"], [$reason, "\n", "§"], $cfg->get("whitelist.message"));
			$whitelistedMessage = str_replace(["{line}", "&"], ["\n", "§"], $cfg->get("whitelist.reason")); //To-do see if this method works.
			$player->close("", $whitelistedMessage);
		}
	    //Custom banned system:
	         if(!$player->isBanned($name)) {
	    $banList = $player->getServer()->getNameBans();
	    $banEntry = $banList->getEntries();
            $entry = $banEntry[strtolower($name)];
                $reason = $entry->getReason();
                if ($reason != null || $reason != "") {
                       $bannedMessage = str_replace(["{line}", "&", "{reason}"], ["\n", "§", $reason], $cfg->get("banned.message")); 
		} else {
			$bannedMessage = str_replace(["{line}", "&"], ["\n", "§"], $cfg->get("no.banned.reason.message"));
			$player->close("", $bannedMessage);
                }
	}
}
	}
