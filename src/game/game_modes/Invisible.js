import { BaseGame } from "./BaseGame.js";
import { Wordle } from "../Wordle.js";

export class Invisible extends BaseGame
{
    constructor(wordle)
    {
        super(wordle);
    }

    play()
    {
        console.log("Invisible");
        this.cacher(true);
    }

    stop()
    {
        this.cacher(false);
    }

    cacher(estCache)
    {
        let elements = document.getElementsByClassName('box');
        
        for (let i = 0; i < elements.length; i++) {
            let element = elements[i];
            if(estCache) element.style.fontSize = "0em";
            else element.style.fontSize = "2.5em"
        }
    }
}