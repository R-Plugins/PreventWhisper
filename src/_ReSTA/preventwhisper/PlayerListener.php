<?php

namespace _ReSTA\preventwhisper;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerCommandPreprocessEvent;

use pocketmine\utils\TextFormat;

use pocketmine\Server;

use pocketmine\Player;

class PlayerListener implements Listener
{
	
	private $api;
	
	public function __construct(PreventWhisper $api)
	{
		$this->api = $api;
	}
	
	public function onPlayerCommand(PlayerCommandPreprocessEvent $event)
	{		  	
		$cmd = explode(" ", $event->getMessage());
		
		$sender = $event->getPlayer();
		
		if($cmd[0] === "/tell")
		{
			$player = Server::getInstance()->getPlayer($cmd[1]);
			
			if($player instanceof Player)
			{
				
				if(!$event->isCancelled() && $this->api->isAdded($player))
				{
					$sender->sendMessage(TextFormat::RED . "You can't send whisper messages to " . $player->getName() . ". `" . $this->api->getMessage($player) . "`");
					
					$event->setCancelled();
				}
			}
		}				
	}	
}

?>
