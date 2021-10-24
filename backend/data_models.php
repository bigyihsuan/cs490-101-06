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

class Question
{
    public string $prompt;
    public string $type;
    public string $difficulty;

    public function __construct(string $prompt, string $type, string $difficulty)
    {
        $this->prompt = $prompt;
        $this->type = $type;
        $this->difficulty = $difficulty;
    }
}

class TestCase
{
    public string $in;
    public string $out;

    public function __construct(string $in, string $out)
    {
        $this->in = $in;
        $this->out = $out;
    }
}