<?php
namespace App\personnal;
/**
 * Created by IntelliJ IDEA.
 * User: Loulouw
 * Date: 27/12/2016
 * Time: 00:48
 */
class Episode
{

    private $episode,$actors,$vue;

    public function __construct($episode,$actors,$vue)
    {
        $this->episode=$episode;
        $this->actors=$actors;
        $this->vue=$vue;
    }

    public function getEpisode(){
        return $this->episode;
    }

    public function getActors(){
        return $this->actors;
    }

    public function getVue(){
        return $this->vue;
    }

}