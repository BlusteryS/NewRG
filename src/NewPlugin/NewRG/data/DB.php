<?php

declare(strict_types=1);

namespace NewPlugin\NewRG\data;

use pocketmine\world\Position;
use SQLite3;
use function strtolower;
use const SQLITE3_ASSOC;

class DB {
	public function __construct(private SQLite3 $regions) {
	}

	public function contains(string $name) : bool {
		return $this->regions->query("SELECT nick FROM users WHERE name = '" . strtolower($name) . "'")->fetchArray(SQLITE3_ASSOC) !== FALSE;
	}

	public function getByName(string $name, string $get) : string|bool|int {
		return $this->regions->query("SELECT `$get` FROM regions WHERE name = '" . strtolower($name) . "'")->fetchArray(SQLITE3_ASSOC)[$get];
	}

	public function getByPos(Position $pos, string $get) : string|bool|int {
		$x = $pos->getFloorX();
		$y = $pos->getFloorY();
		$z = $pos->getFloorZ();
		return $this->regions->query(
			"SELECT `$get` FROM regions WHERE minX <= $x AND maxX >= $x AND minY <= $y AND maxY >= $y AND minZ <= $z AND maxZ >= $z"
		)->fetchArray(SQLITE3_ASSOC)[$get];
	}

	public function set(string $name, string $get, string|bool|int $set) : void {
		$this->regions->query("UPDATE regions SET `$get` = '$set' WHERE name = '" . strtolower($name) . "'");
	}
}