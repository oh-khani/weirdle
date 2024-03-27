import { ModeJeu } from "./ModeJeu";

export class Chronometre extends ModeJeu
{
    #minute = 3;
    #seconde = 0;
    #timer;

    constructor()
    {

    }

    constructor(minute, seconde)
    {
        this.#minute = minute;
        this.#seconde = seconde;
    }

    play()
    {
        this.#timer = setInterval(()=>{
            ele.innerHTML = '00:'+sec;
            sec ++;
          }, 1000) // each 1 second
        () 
    }

    stop()
    {
        clearInterval(this.#timer);
    }


    #setChrono(minute, seconde)
    {
        this.#minute = minute;
        this.#seconde = seconde;
    }
}