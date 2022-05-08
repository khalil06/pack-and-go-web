<?php
// src/Service/MessageGenerator.php
namespace App\Service;



class Generator
{
    private string $result;

    public function __construct()
    {
        $this->result = "";
    }


    public function getResult(): string
    {
        return $this->result;
        // ...
    }

    public function setResult($result): void
    {
        $this->result = $result;
    }
}
