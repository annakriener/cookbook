<?php

namespace CookbookBundle\Entity;

class Recipe {
    protected $title;
    protected $author;
    protected $source;
    protected $duration;
    protected $servings;
    protected $preparation;
    protected $instruction;
    protected $imageURL;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function setDuration($duration){
        $this->duration = $duration;
    }

    public function getServings() {
        return $this->servings;
    }

    public function setServings($servings) {
        $this->servings = $servings;
    }

    public function getPreparation() {
        return $this->preparation;
    }

    public function setPreparation($preparation) {
        $this->preparation = $preparation;
    }

    public function getInstruction() {
        return $this->instruction;
    }

    public function setInstruction($instruction) {
        $this->instruction = $instruction;
    }

    public function getImageURL() {
        return $this->imageURL;
    }

    public function setImageURL($imageURL) {
        $this->imageURL = $imageURL;
    }
}