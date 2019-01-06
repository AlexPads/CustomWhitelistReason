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
    public function onPreLogin(PlayerPreLoginEvent $event) {
		$cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$reason = $cfg->get("whitelist.reason");
		$player = $event->getPlayer();
		$name = $player->getName();
		
		if(!$player->isWhitelisted($name)) {
			$msg =
				TF::BOLD . TF::GRAY . "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n" . 
				TF::RESET . TF::RED . "                     Whitelisted\n" . 
				TF::RESET . TF::RED . "Why?" . TF::GOLD . $reason;
			$player->close("", $msg);
		}
	}
}
