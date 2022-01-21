<?php

declare(strict_types=1);

namespace NewPlugin\NewRG\utils;

use JetBrains\PhpStorm\Pure;
use pocketmine\Server;
use pocketmine\world\Position;

class CuboidRegion {
	public function __construct(private Position $min, private Position $max) {
	}

	public static function fromXYZ(Position $min, Position $max) : CuboidRegion {
		if ($min->getFloorX() > $max->getFloorX()) {
			$x1 = $max->getFloorX();
			$x2 = $min->getFloorX();
		} else {
			$x1 = $min->getFloorX();
			$x2 = $max->getFloorX();
		}
		if ($min->getFloorY() > $max->getFloorY()) {
			$y1 = $max->getFloorY();
			$y2 = $min->getFloorY();
		} else {
			$y1 = $min->getFloorY();
			$y2 = $max->getFloorY();
		}
		if ($min->getFloorZ() > $max->getFloorZ()) {
			$z1 = $max->getFloorZ();
			$z2 = $min->getFloorZ();
		} else {
			$z1 = $min->getFloorZ();
			$z2 = $max->getFloorZ();
		}
		$world = $max->getWorld();
		return new CuboidRegion(new Position($x1, $y1, $z1, $world), new Position($x2, $y2, $z2, $world));
	}

	public function getMin() : Position {
		return $this->min;
	}

	public function getMax() : Position {
		return $this->max;
	}

	public function getSize() : int {
		$min = $this->min->asVector3();
		$max = $this->max->asVector3();
		return ($max->getX() - $min->getX() + $max->getZ() - $min->getZ()) * ($max->getY() - $min->getY());
	}

	public function getPlayers() : array {
		$players = [];
		foreach (Server::getInstance()->getOnlinePlayers() as $player) {
			$loc = $player->getLocation();
			$x = $loc->getX();
			$y = $loc->getY();
			$z = $loc->getZ();
			if ($x >= $this->min->getFloorX() && $x < $this->max->getFloorX() + 1 && $y >= $this->min->getFloorY() && $y < $this->max->getFloorY() + 1 && $z >= $this->min->getFloorZ() && $z < $this->max->getFloorZ() + 1) {
				$players[] = $player;
			}
		}
		return $players;
	}

	#[Pure]
	public function contains(Position $loc) : bool {
		$x = $loc->getX();
		$y = $loc->getY();
		$z = $loc->getZ();
		return $x >= $this->min->getFloorX() && $x < $this->max->getFloorX() + 1 && $y >= $this->min->getFloorY() && $y < $this->max->getFloorY() + 1 && $z >= $this->min->getFloorZ() && $z < $this->max->getFloorZ() + 1;
	}
}
