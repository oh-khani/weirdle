import { Wordle } from "../Wordle.js";

/**
 * Base de tous les modes de jeu. (Classe Parent)
 */
export class BaseGame
{
    #wordle;

    constructor(wordle)
    {
        this.#wordle = wordle; //Reference au jeu en cours
        if(this.#wordle instanceof Wordle)
        {
            console.log("WORDLE FONCTIONNEL");
        }
        else
        {
            console.log(typeof this.#wordle);
        }
    }
    
    /**
     * Fonctionnement du mode de jeu au debut de la partie.
     */
    play()
    {

    }

    /**
     * Arrete le mode de jeu quand la partie est terminee.
     */
    stop()
    {

    }
}
