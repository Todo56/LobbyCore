<?php
namespace todo56\LobbyCore;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerInteractEvent;
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;

class CoreListener implements Listener {
    protected $plugin;
    protected $hotbar;
    public function __construct(LobbyCore $plugin)
    {
        $this->plugin = $plugin;
        $this->hotbar = $this->plugin->config->get("hotbar");
    }
    public function onJoin(PlayerJoinEvent $ev){
        $player = $ev->getPlayer();
        $player->getInventory()->setItem($this->hotbar["fly-item"]["slot"], Item::get($this->hotbar["fly-item"]["item-id"], 0)->setCustomName($this->hotbar["fly-item"]["name"]));
        $player->getInventory()->setItem(3, Item::get(369, 0)->setCustomName("Toggle Players"));
    }
    public function onInteract(PlayerInteractEvent $ev){
        $player = $ev->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        switch ($item->getName()){
            case $this->hotbar["fly-item"]["name"]:
                $form = new SimpleForm(function (Player $pl, $data){
                    if($data === 0){
                        $pl->setAllowFlight(true);
                        $pl->sendMessage($this->hotbar["fly-item"]["form"]["enable-message"]);
                    } else if ($data === 1){
                        $pl->setAllowFlight(false);
                        $pl->sendMessage($this->hotbar["fly-item"]["form"]["disable-message"]);
                    }
                });
                $form->setTitle($this->hotbar["fly-item"]["form"]["title"]);
                $form->addButton($this->hotbar["fly-item"]["form"]["enable-button"]);
                $form->addButton($this->hotbar["fly-item"]["form"]["disable-button"]);
                $form->sendToPlayer($player);
                break;
        }
    }
}


