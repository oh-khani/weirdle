import { Wordle } from './Wordle.js';
import { Chronometre } from './game_modes/Chronometre.js';
import { Invisible } from './game_modes/Invisible.js'
import { BaseGame } from './game_modes/BaseGame.js'


const wordle = new Wordle();

// Affichage menu pour choisir ses modes
document.addEventListener("DOMContentLoaded", () =>{
    document.getElementById("main-container").style.display = "none";

    // Lancer le mode normal
    document.getElementById("mode-normal").addEventListener("click", () => {
        wordle.setMode(new BaseGame(wordle));

        document.getElementById("menu").style.display = "none";
        document.getElementById("main-container").style.display = "block";

        wordle.startGame();
    });

    // Lancer le mode chronomètre
    document.getElementById("mode-chrono").addEventListener("click", () => {
        wordle.setMode(new Chronometre(wordle));

        document.getElementById("menu").style.display = "none";
        document.getElementById("main-container").style.display = "block";

        wordle.startGame();
    });

    // Lancer le mode invisible
    document.getElementById("mode-inv").addEventListener("click", () => {
        wordle.setMode(new Invisible(wordle));

        document.getElementById("menu").style.display = "none";
        document.getElementById("main-container").style.display = "block";

        wordle.startGame();
    });

})
