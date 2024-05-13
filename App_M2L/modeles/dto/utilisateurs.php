<?php
class Utilisateurs
{
	private array $utilisateurs ;

	public function __construct($array)
    {
		if (is_array($array))
        {
			$this->utilisateurs = $array;
		}
	}

	public function getUsers(): array
    {
		return $this->utilisateurs;
	}

	public function findUsers($unIdUtilisateur)
    {
		$i = 0;
		while ($unIdUtilisateur != $this->utilisateurs[$i]->getIdUser() && $i < count($this->utilisateurs)-1)
        {
			$i++;
		}
		if ($unIdUtilisateur == $this->utilisateurs[$i]->getIdUser())
        {
			return $this->utilisateurs[$i];
		}
	}

	public function firstUser()
    {
		return $this->utilisateurs[0]->getIdUser();
	}

}