<?php

namespace HealStick\Items;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\VanillaItems;
use pocketmine\utils\Config;

use HealStick\Main;

class Heal implements Listener{

    private $cooldown;

    public function onInteract(PlayerInteractEvent $event){

        $player = $event->getPlayer();

        if ($player->getInventory()->getItemInHand()->getId() === VanillaItems::BLAZE_ROD()->getId()) {
            if(isset($this->cooldown[$player->getName()]) && $this->cooldown[$player->getName()] > time()){
                $event->cancel();
                $time = $this->cooldown[$player->getName()] - time();
                $player->sendPopup(str_replace("{time}", "$time", $this->getConfig()->get("cooldown-msg")));
            }if (!$event->isCancelled()) {
                $player->setHealth($player->getHealth() + $this->getConfig()->get("pv"));
                $player->sendPopup($this->getConfig()->get("heal-msg"));
                $this->cooldown[$player->getName()] = time() + $this->getConfig()->get("cooldown");
            }
        }
    }

    public function getConfig()
    {
        return new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
    }
}