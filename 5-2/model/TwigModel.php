<?php

abstract class TwigModel
{
    protected $db = null;

    protected function getDB()
    {
        return $this->db;
    }
}