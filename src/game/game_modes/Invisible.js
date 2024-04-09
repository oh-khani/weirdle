import { ModeJeu } from "./ModeJeu.js";
import { Wordle } from "../Wordle.js";

export class Invisible extends ModeJeu
{
    constructor(wordle)
    {
        super(wordle);
    }

    play()
    {
        console.log("Invisible");
        this.#cacher(true);
    }

    stop()
    {
        this.#cacher(false);
    }

    #cacher(estCache)
    {
        var elements = document.getElementsByClassName('box');

        for (var i = 0; i < elements.length; i++) {
        var element = elements[i];
            if(estCache) element.style.fontSize = "0em";
            else element.style.fontSize = "2.5em"
        }
    }
}