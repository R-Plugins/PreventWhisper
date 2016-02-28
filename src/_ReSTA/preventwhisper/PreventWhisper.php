<?php

namespace _ReSTA\preventwhisper;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\utils\TextFormat;

use pocketmine\Player;

class PreventWhisper extends PluginBase
{
	
	private $players;
	
	public function onEnable()
	{		
		$this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args)
	{
		
		if(!$sender instanceof Player)
		{
			$sender->sendMessage(TextFormat::RED . "This command can only be excute from in-game!");
			
			return true;
		}
		
		if($this->isAdded($sender))
		{
			$this->removePlayer($sender);
			
			$sender->sendMessage(TextFormat::GOLD . "You aren't prevent-whisper mode. From now on, You can recive whisper messages from other players.");
			
			return true;
		}
		
		if(count($args) >= 1)
		{
			$message = implode(" ", $args);
			
			$this->addPlayer($sender, $message);
			
			$sender->sendMessage(TextFormat::GREEN . "You are prevent-whisper mode. other players can't send whisper messages to you.");
			
			return true;
		}
		
		$this->addPlayer($sender);
		
		$sender->sendMessage(TextFormat::GREEN . "You are prevent-whisper mode. other players can't send whisper messages to you.");
		
		return true;		
	}
	
	public function addPlayer(Player $player, $message = "No reason...")
	{
		$this->players[$player->getName()] = $message;
	}
	
	public function isAdded(Player $player)
	{
		return isset($this->players[$player->getName()]);
	}
	
	public function removePlayer(Player $player)
	{
		unset($this->players[$player->getName()]);
	}	
	
	public function getMessage(Player $player){
		return $this->players[$player->getName()];
	}
}

?>

?>
