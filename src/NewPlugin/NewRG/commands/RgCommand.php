<?php

declare(strict_types=1);

namespace NewPlugin\NewRG\commands;

use NewPlugin\NewRG\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class RgCommand extends Command {
	public function __construct(private Main $plugin) {
		parent::__construct("rg", "Управление регионами", NULL, ["region"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		// todo
	}
}