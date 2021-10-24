<?php

class User
{
    public const STUDENT = "STUDENT";
    public const TEACHER = "TEACHER";

    public int $id;
    public string $username;
    public string $pass;
    public string $access;

    public function __construct(int $id, string $username, string $pass, string $access)
    {
        $this->id = $id;
        $this->username = $username;
        $this->pass = $pass;
        $this->access = $access;
    }
}