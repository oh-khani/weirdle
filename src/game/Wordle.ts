import data from '../Dico/dictionnaire.json' assert { type: 'json' };

class Wordle
{
    private mode : IModeJeu;
    private state : IState;
    private dico : string[] = data.mots;
    private mot : string;
    private nombreEssai = 6;


    constructor()
    {
        this.mot = this.dico[Math.floor(Math.random() * this.dico.length)].toLowerCase();
        this.state = {
            secret: this.mot,
            grid: Array(this.nombreEssai).fill([]).map(() => Array(this.mot.length).fill('')),
            currentRow: 0,
            currentCol: 0
        };
    
    }

    setMode(mode : IModeJeu){this.mode = mode; }
    startGame(){}
}
