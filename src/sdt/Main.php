<?php
/*
SDT - XP => 附魔點數
*/
namespace sdt;

use pocketmine\plugin\PluginBase;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\inventory\Inventory;
use pocketmine\entity\Entity;
use pocketmine\item\{Item , enchantment\Enchantment , enchantment\EnchantmentInstance};
use pocketmine\utils\{Config, TextFormat as C};
use pocketmine\{Server, Player};
use sdt\jojoe77777\FormAPI\{CustomForm, Form, FormAPI, ModalForm, SimpleForm};
use pocketmine\event\player\{PlayerExhaustEvent, PlayerItemHeldEvent, PlayerKickEvent, PlayerMoveEvent, PlayerLoginEvent, PlayerQuitEvent, PlayerChatEvent, PlayerDeathEvent, PlayerJoinEvent, PlayerInteractEvent, PlayerDropItemEvent};
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use onebone\economyapi\EconomyAPI;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("XPChange已經載入");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool
    {
        switch ($cmd->getName()) {
        case "xpchange":
        $level = $sender->getXpLevel();//獲取玩家的等級
        
        if($level >= 1){//如果等級大於等於1，即允許玩家執行該操作
        $name = strtolower($sender->getName());
        $addToken = $level / 1; //當前等級 / 1 = Ex 10 / 1 = 10附魔點數
        $sender->setXpLevel(0);//設置為0
        $this->getServer()->getPluginManager()->getPlugin("KPoints")->addPoint($name , $addToken);
        $sender->sendMessage("§d[XP] >>> §a已經將等級轉換為{$addToken}點附魔點數!");
        }else{
        $sender->sendMessage("§c你沒有任何等級!");
        }
        return true;

        case "setxp":
        $sender->setXpLevel(1000);
        return true;
        
        }
        return true;
}

public function onDisable(){
    $this->getLogger()->info("XPChange已經卸載");
}
}
