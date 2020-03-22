<?php
namespace todo56\LobbyCore;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class LobbyCore extends PluginBase {
    public $config;
    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getLogger()->info("Plugin Enabled");
        $this->getServer()->getPluginManager()->registerEvents(new CoreListener($this), $this);
    }

}