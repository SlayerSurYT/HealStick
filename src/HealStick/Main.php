<?php

namespace HealStick;

use pocketmine\plugin\PluginBase;
use HealStick\Items\Heal;

class Main extends PluginBase{

    public static Main $instance;

    public function onEnable(): void{

        self::$instance = $this;
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
        $this->getServer()->getLogger()->notice("Plugin HealStick activer");

        $this->getServer()->getPluginManager()->registerEvents(new Heal(), $this);
    }

    public static function getInstance() : Main{
        return self::$instance;
    }
}