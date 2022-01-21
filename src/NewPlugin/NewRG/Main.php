<?php

declare(strict_types=1);

namespace NewPlugin\NewRG;

use NewPlugin\NewRG\commands\RgCommand;
use pocketmine\plugin\PluginBase;
use SQLite3;

class Main extends PluginBase {
	public SQLite3 $regions;

	public function onEnable() : void {
		$this->initDB();
		$this->registerCommands();
	}

	private function registerCommands() {
		$this->getServer()->getCommandMap()->register("soulapi", new RgCommand($this));
	}

	private function initDB() {
		$this->regions = new SQLite3($this->getDataFolder() . "regions.db");
		$regions = [
			"name TEXT NOT NULL",
			"owner TEXT NOT NULL",
			// Позиции:
			"minX INT NOT NULL",
			"maxX INT NOT NULL",
			"minY INT NOT NULL",
			"maxY INT NOT NULL",
			"minZ INT NOT NULL",
			"maxZ INT NOT NULL"
		];
		$this->regions->query("CREATE TABLE IF NOT EXISTS regions (" . join(", ", $regions) . ")");
	}
}