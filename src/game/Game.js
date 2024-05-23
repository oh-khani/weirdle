import { Wordle } from './Wordle.js';
import { Chronometre } from './game_modes/Chronometre.js';
import { Invisible } from './game_modes/Invisible.js'


const wordle = new Wordle();
let modeChoisis = "chronometre";

switch (modeChoisis) 
{
    case "invisible": wordle.setMode(new Invisible(wordle)); break;
    case "chronometre": wordle.setMode(new Chronometre(wordle)); break;
    case "difficile": wordle.setMode(new Chronometre(wordle)); break;
    default: break;
}

wordle.startGame();