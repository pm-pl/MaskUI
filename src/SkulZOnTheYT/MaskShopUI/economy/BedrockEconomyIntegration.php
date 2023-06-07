<?php

declare(strict_types=1);

namespace SkulZOnTheYT\MaskShopUI\economy;

use Closure;
use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use cooldogedev\BedrockEconomy;
use cooldogedev\libSQL\context\ClosureContext;
use InvalidArgumentException;
use pocketmine\player\Player;
use SkulZOnTheYT\MaskShopUI\Main;
use pocketmine\Server;
use function assert;

final class BedrockEconomyIntegration implements EconomyIntegration{

    public function init(array $config) : void{
	}

	public function getMoney(Player $player, Closure $callback) : void{
		$player->getInstance()->getPlayerBalance($player->getName(), ClosureContext::create(static function(?int $balance) use($callback) : void{
			$callback($balance ?? 0);
		}));
	}

	public function addMoney(Player $player, float $money) : void{
		$player->getInstance()->addToPlayerBalance($player->getName(), (int) ceil($money));
	}

	//Thanks for the Repair @cooldogedev
	public function removeMoney(Player $player, float $money, Closure $callback) : void{
		$player->getInstance()->subtractFromPlayerBalance($player->getName(), (int) ceil($money), ClosureContext::create(static function(bool $success) use($callback) : void{
			$callback($success);
		}));
	}

	public function formatMoney(float $money) : string{
		return $this->plugin->getCurrencyManager()->getSymbol() . number_format($money);
	}
}
