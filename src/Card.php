<?php

namespace App;

class Card
{
    /** @var string The card's value */
    protected $value;

    /** @var string The cards suit */
    protected $suit;

    /**
     * Create a new Card object.
     *
     * @param string $value The value of the card
     * @param string $suit  The suit of the card
     */
    public function __construct(string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    /**
     * Magic getter method for returning protected property values.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->{$property};
    }

    /**
     * Return the card as a string.
     *
     * @return string
     */
    public function __toString() : string
    {
        return "{$this->value}{$this->suit}";
    }
}
