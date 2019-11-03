<?php

namespace App\Commands;

use App\Deck;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Play extends Command
{
    /** @var string The default command name */
    protected static $defaultName = 'play';

    /** @var \App\Deck A deck of cards */
    protected $deck;

    /**
     * Create a new Play command.
     */
    public function __construct(Deck $deck)
    {
        $this->deck = $deck->shuffle();

        parent::__construct();
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Play the game');
        $this->setHelp('This command will start the game');

        // $this->addOption('iterations', 'i', InputOption::VALUE_REQUIRED, 'The number iterations of the game run');
    }

    /**
     * Executes the current command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @return int|null null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $assertions = array_merge(...array_fill(0, 4, [
            'A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'
        ]));

        $results = array_map(function ($assertion) {
            return [
                'assert' => $assertion,
                'draw' => $drawn = $this->deck->drawOne(),
                'match' => $assertion == $drawn->value
            ];
        }, $assertions);

        $io->table(['Assert', 'Draw', 'Match'], array_map(function ($result) {
            return [$result['assert'], $result['draw'], $result['match'] ? '<fg=red>✗</>' : '<fg=green>✔</>'];
        }, $results));

        $victory = array_reduce($results, function ($carry, $result) {
            return $carry && ! $result['match'];
        }, true);

        if ($victory) {
            $output->writeln('<fg=green>YOU HAVE ERMERGED VICTORIOUS!!!</>');

            return 0;
        }

        $output->writeln('<fg=red>Your journey ends in sorrow</>');

        return 1;
    }
}
