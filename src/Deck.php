<?php

namespace App;

class Deck
{
    /** @var \App\Cards[] Array of cards in the deck */
    protected $cards = [];

    /**
     * Create a new Deck of cards.
     */
    public function __construct()
    {
        foreach (['♠', '♥', '♦', '♣'] as $suit) {
            foreach (['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'] as $value) {
                $this->cards[] = new Card($value, $suit);
            }
        }
    }

    /**
     * Randomize the order of cards in the deck.
     *
     * @param int $iterations
     *
     * @return self
     */
    public function shuffle(int $iterations = 3) : self
    {
        for ($i = 1; $i <= $iterations; $i++) {
            shuffle($this->cards);
        }

        return $this;
    }

    /**
     * Remove and return one or more cards from a specific position in the deck.
     *
     * @param int $length The number of cards to draw
     * @param int $offset The position from which to draw the cards
     *
     * @return \App\Card[]
     */
    public function draw(int $length = 1, int $offset = 0) : array
    {
        return array_splice($this->cards, $offset, $length);
    }

    /**
     * Convinience function for drawing a single card from the deck.
     *
     * @param int $offset The position from which to draw a card
     *
     * @return \App\Card
     */
    public function drawOne(int $offset = 0) : Card
    {
        return $this->draw(1, $offset)[0];
    }

    /**
     * Return an ordered array of cards in the deck.
     *
     * @return array
     */
    public function fan() : array
    {
        return $this->cards;
    }
}
