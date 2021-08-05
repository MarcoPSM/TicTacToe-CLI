
<?php
/**
 *   cd /var/www/html/workspace/JogoGalo
 *   php vendor/bin/phpunit tests/
 *   php index.php
 *   Links:
 * https://www.geeksforgeeks.org/minimax-algorithm-in-game-theory-set-3-tic-tac-toe-ai-finding-optimal-move/
 * https://github.com/BennyThadikaran/TicTacToe
 * 
 */

require_once "src/players/IPlayer.php";
require_once "src/players/Player.php";
require_once "src/players/PlayerAI.php";
require_once "src/board/Board.php";
require_once "src/board/Mark.php";
require_once "src/board/GameUi.php";
require_once "src/board/TicTacToe.php";


use board\Board;
use players\Player;
use players\PlayerAI;


print("Enter your name? (Player1)\n");
$player1Name = trim(fgets(STDIN));
$player1Name = (empty($player1Name)
    ? 'Player1'
    : $player1Name
);

$player1 = new Player($player1Name);

// Assign the second player
print("Play against a computer? (y)\n");
$useBot = trim(fgets(STDIN));

// Play against AI bot
if (in_array($useBot, ['y', 'Y', ''])) {
    $player2 = new PlayerAI();
    print("\033[1;36m{$player2->getName()} joined the game.\033[0m\n\n");
} else {

    // or play another human
    print("Enter the second player's name? (Player2)\n");
    $player2Name = trim(fgets(STDIN));
    $player2Name = (empty($player2Name)
        ? 'Player2'
        : $player2Name
    );

    $player2 = new Player($player2Name);
    print("Welcome {$player1->getName()} and {$player2->getName()}\n");
}


// initialize the game
$board = new Board();
$ui = new GameUi();
$game = new TicTacToe($board, $ui, $player1, $player2);

$game->start();
