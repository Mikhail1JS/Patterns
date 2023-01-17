<?php

interface INotify
{
    public function send();
}

class SmsNotify implements INotify
{

    private $client = new SmsAlert();

    public function send()
    {
        $this->client->alert();
    }

}

abstract class NotifyDecorator implements INotify
{

    protected $content = null;

    public function __construct(INotify $content)
    {
        $this->content = $content;
    }

    public function send()
    {
        // TODO: Implement send() method.
    }
}

class EmailNotify extends NotifyDecorator
{

    private $client = new EmailAlert();

    public function send()
    {
        $this->client->notify();
        $this->content->send();
    }

}

class CnNotify extends NotifyDecorator
{
    private $client = new CnAlert();

    public function send()
    {
        $this->client->inform();
        $this->content->send();
    }
}

$notify = new CnNotify(
    new EmailNotify(
        new SmsNotify()
    )
);

// Task 2

interface ISquare
{
    function squareArea(int $sideSquare);
}

interface ICircle
{
    function circleArea(int $circumference);
}

class SquareAreaLib
{
    public function getSquareArea(int $diagonal)
    {
        $area = ( $diagonal ** 2 ) / 2;
        return $area;
    }
}

class CircleAreaLib
{
    public function getCircleArea(int $diagonal)
    {
        $area = ( M_PI * $diagonal ** 2 ) / 4;
        return $area;
    }
}



class squareAdapter implements ISquare {

    public function __construct(private SquareAreaLib $adaptee){

    }
    public function squareArea(int $sideSquare)
    {
        $diagonal = $sideSquare * sqrt(2);
        return $this->adaptee->getSquareArea($diagonal);
    }
}

class circleAdapter implements ICircle {

    public function __construct(private CircleAreaLib $adaptee){

    }
    public function circleArea(int $circumference)

    {
        $diameter = $circumference / M_PI;

        return $this->adaptee->getCircleArea($diameter);

    }
}