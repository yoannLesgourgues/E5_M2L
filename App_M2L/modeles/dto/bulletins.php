<?php
class bulletins{
	private array $bulletins ;

	public function __construct($array){
		if (is_array($array)) {
			$this->bulletins = $array;
		}
	}

	public function getBulletins(){
		return $this->bulletins;
	}

	public function chercheBulletin($unIdBulletin){
		$i = 0;
		while ($unIdBulletin != $this->bulletins[$i]->getIdBulletin() && $i < count($this->bulletins)-1){
			$i++;
		}
		if ($unIdBulletin == $this->bulletins[$i]->getIdBulletin()){
			return $this->bulletins[$i];
		}
	}

	public function PremierBulletin(){
		return $this->bulletins[0]->getIdBulletin();
	}
}