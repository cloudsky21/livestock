<?php
class Question
{
    private $author;
    private $question;

    public function __construct($question, Author $author)
    {
        $this->author = $author;
        $this->question = $question;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getQuestion()
    {
        return $this->question;
    }
}
