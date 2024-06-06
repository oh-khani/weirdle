import { Wordle } from './Wordle.js';
import { Chronometre } from './game_modes/Chronometre.js';
import { Invisible } from './game_modes/Invisible.js'
import { BaseGame } from './game_modes/BaseGame.js'


const wordle = new Wordle();
let modeChoisis = "normal";

switch (modeChoisis) 
{
    case "invisible": wordle.setMode(new Invisible(wordle)); break;
    case "chronometre": wordle.setMode(new Chronometre(wordle)); break;
    case "difficile": wordle.setMode(new Chronometre(wordle)); break;
    case "normal": wordle.setMode(new BaseGame(wordle)); break;
    default: break;
}

wordle.startGame();