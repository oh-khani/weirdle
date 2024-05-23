import { Wordle } from "../Wordle.js";

/**
 * Base de tous les modes de jeu. (Classe Parent)
 */
export class ModeJeu
{
    _wordle;

    constructor(wordle)
    {
        this._wordle = wordle; //Reference au jeu en cours
        if(this._wordle instanceof Wordle)
        {
            console.log("WORDLE FONCTIONNEL");
        }
        else
        {
            console.log(typeof this._wordle);
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
