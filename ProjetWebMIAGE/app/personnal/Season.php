<?php
namespace App\personnal;
/**
 * Created by IntelliJ IDEA.
 * User: Loulouw
 * Date: 27/12/2016
 * Time: 00:48
 */
class Season
{

    private $episodes,$season;

    public function __construct($season,$episodes)
    {
        $this->season = $season;
        $this->episodes = $episodes;
    }

    public function getEpisodes(){
        return $this->episodes;
    }

    public function getSeason(){
        return $this->season;
    }

}