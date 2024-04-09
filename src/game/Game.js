import { Wordle } from './Wordle.js';
import { Chronometre } from './game_modes/Chronometre.js';
import { Invisible } from './game_modes/Invisible.js'

const wordle = new Wordle();
wordle.setMode(new Invisible(wordle));
wordle.startGame();