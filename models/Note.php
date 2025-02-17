<?php

class Note
{
    public $title;
    public $description;

    public function __construct($title, $description = "")
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
