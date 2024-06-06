import { BaseGame } from "./BaseGame.js";
import { Wordle } from "../Wordle.js";

export class Chronometre extends BaseGame
{
    #minute = 1;
    #seconde = 30;
    #timer;
    #texteChrono;

    constructor(wordle)
    {
        super(wordle);
        this.tempsAleatoire(0,0, 0, 10); //Temps aleatoire Minute : min -> 1 max -> 1 | Seconde : min -> 0 max -> 59
        this.#texteChrono = document.createElement('h2');
        this.#texteChrono.setAttribute("id","chrono");

        this.#seconde < 10 ? this.#seconde = "0" + this.#seconde : this.#seconde = this.#seconde ;
        
        this.#texteChrono.textContent = "0" + this.#minute + " : " + this.#seconde;

        let container = document.getElementById("main-container"); 
        let boutons = document.getElementById("button-container");
        
        container.insertBefore(this.#texteChrono, boutons);
    }

    play()
    {
        console.log("CHRONO");
        this.#timer = setInterval(() => this.decompter(this.#minute, this.#seconde, this._wordle), 1000);
    }

    stop()
    {
        clearInterval(this.#timer);
    }


    setChrono(minute, seconde)
    {
        this.#minute = minute;
        this.#seconde = seconde;
    }

    decompter(minute, seconde, wordle)
    {
        let chrono = document.getElementById('chrono')
        seconde < 10 ? chrono.textContent = '0' + minute + ' : 0' + seconde : chrono.textContent = '0' + minute + ' : ' + seconde;

        seconde--;
        if (seconde < 0) 
        {
            minute--;
            seconde = 59;
        }

        if(minute < 0)
        {
            console.log("FIN DU CHRONO");
            document.getElementById('chrono').textContent = '00 : 00';
            this._wordle.endGame();
        }
        this.setSec(seconde);
        this.setMin(minute);
    }

    getMin(){return this.#minute;}
    getSec(){return this.#seconde;}
    setMin(min){this.#minute = min;}
    setSec(sec){this.#seconde = sec;}
    
    /**
     * Genere un temps aleatoire entre une intervalle donnee.
     * @param {*} minMinute 
     * @param {*} maxMinute 
     * @param {*} minSeconde 
     * @param {*} maxSeconde 
     */
    tempsAleatoire(minMinute, maxMinute, minSeconde, maxSeconde)
    {
        this.#minute = Math.floor(Math.random() * (maxMinute - minMinute + 1) + minMinute);
        this.#seconde = Math.floor(Math.random() * (maxSeconde - minSeconde + 1) + minSeconde);
    }
}
