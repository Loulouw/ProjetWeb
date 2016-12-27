<?php
namespace App\personnal;
/**
 * Created by IntelliJ IDEA.
 * User: Loulouw
 * Date: 27/12/2016
 * Time: 00:47
 */
class Serie
{

    private $serie,$seasons,$genres,$creators,$companies;

    public function __construct($serie,$seasons,$genres,$creators,$companies)
    {
        $this->serie=$serie;
        $this->seasons = $seasons;
        $this->genres = $genres;
        $this->creators = $creators;
        $this->companies = $companies;
    }

    public function getSerie(){
        return $this->serie;
    }

    public function getSeasons(){
        return $this->seasons;
    }

    public function getGenres(){
        return $this->genres;
    }

    public function getCreators(){
        return $this->creators;
    }

    public function getCompanies(){
        return $this->companies;
    }

}