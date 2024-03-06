import data from '../Dico/dictionnaire.json' assert { type: 'json' };
import { State } from './State.js';
import { ModeJeu } from './game_modes/ModeJeu.js';

//Importe tous les modes de jeu
//const files = await import.meta.glob("./game_modes/ModeJeu/*.js");
//for (const file in files) { await import(file); }

export class Wordle
{
    #mode;// : ModeJeu;
    #state; //: State;
    #dico; //: string[] = data.mots;
    #mot;// : string;
    #nombreEssai = 6;


    constructor()
    {
        this.dico = data.mots;
        this.mot = this.dico[Math.floor(Math.random() * this.dico.length)].toLowerCase();
        this.state = {
            secret: this.mot,
            grid: Array(this.nombreEssai).fill([]).map(() => Array(this.mot.length).fill('')),
            //grid: Array(this.#nombreEssai).fill().map(() => Array(this.#mot.length).fill('')),
            currentRow: 0,
            currentCol: 0
        };
        console.log(this.mot);
        //this.mode = new ModeJeu();
    }

    setMode(mode){this.mode = mode; }
    getMode(){return this.mode;}

    /**
     * 
     * Met à jour la grille de jeu avec les lettres entrées par le joueur
     */
    #update() {
        for (let i = 0; i < this.state.grid.length; i++) {
            for (let j = 0; j < this.state.grid[i].length; j++) {
                const box = document.getElementById(`box-${i}-${j}`);
                box.textContent = this.state.grid[i][j];
            }
        }
    }

    /**
     * 
     * @param {*} container 
     * @param {int} row 
     * @param {int} col 
     * @param {string} lettre 
     * dessine une case de la grille
     */
    #drawBox(container, row, col, lettre='') {
        const box = document.createElement('div');
        box.className = 'box';
        box.id = `box-${row}-${col}`;
        box.textContent = lettre;
        container.appendChild(box);
        return box;
    }

    /**
     * 
     * @param {*} container 
     * @param {int} nbessai
     * @returns {void}
     * dessine la grille de jeu avec le nombre d'essai et la longueur du mot
    */
    #drawGrid(container, nbessai = 6) {
        const longueur = this.state.secret.length;
        const grid = document.createElement('div');
        grid.className = 'grid';
        for (let row = 0; row < longueur+1; row++) {
            for (let col = 0; col < nbessai-1; col++) {
                this.#drawBox(grid, row, col);
            }
        }
        container.appendChild(grid);
    }

    /**
     * 
     * Lis les touches du clavier
     */
    #clavier() {
        document.body.onkeydown = (e) => {
            const lettre = e.key;
            let mot = '';
            if (lettre === 'Enter') {
                if (this.state.currentCol === 5){
                    mot = this.getCurrentWord();
                    if (this.#isWord(mot)) {
                        this.state.currentCol = 0;
                        this.reveal(mot);
                        this.state.currentRow++;
                    }else if (mot  === 'hideo') {
                        document.body.style.backgroundImage = "url('./src/img/hideo-kojima-credits.gif')";
                    }else{
                        alert('Ce n\'est pas un mot');
                    }
                }
            } else if (lettre === 'Backspace') {
                this.#supprLettre();
            } else if (this.#isLetter(lettre)) {
                this.#addLettre(lettre);
            }
            this.#update();
        }
    }

    /**
     * 
     * @param {string} mot 
     * @returns {boolean}
     * return true si le mot est dans le dictionnaire
     */
    #isWord(mot) {return this.dico.includes(mot.toUpperCase());}

    /**
     * 
     * @param {string} lettre 
     * @returns {boolean}
     * return true si la lettre est dans l'alphabet
     */
    #isLetter(lettre) {return lettre.length === 1 && lettre.match(/[a-z]/i);}

    /**
     * 
     * @param {string} lettre 
     * ajoute la lettre dans la grille
     */
    #addLettre(lettre) {
        if (this.state.currentCol === 5) {return;    }
        this.state.grid[this.state.currentRow][this.state.currentCol] = lettre;
        this.state.currentCol++;
    }

    /**
     * 
     * supprime la lettre courante de la grille
     */
    #supprLettre() {
        if (this.state.currentCol === 0) return;
        this.state.grid[this.state.currentRow][this.state.currentCol - 1] = '';
        this.state.currentCol--;
    }

    /**
     * 
     * @param {string} mot 
     * révèle le mot
     */
    reveal(mot) {
        const dure = 500; //ms
        const row = this.state.currentRow;
        //animation de révélation
        for (let i = 0; i < mot.length; i++) {
            const box = document.getElementById(`box-${row}-${i}`);
            const lettre = box.textContent;
            const numOfOccurrencesSecret = this.#getNumOfOccurrencesInWord(this.state.secret,lettre);
            const numOfOccurrencesGuess = this.#getNumOfOccurrencesInWord(mot, lettre);
            const letterPosition = this.#getPositionOfOccurrence(mot, lettre, i);
        
            setTimeout(() => {
                if (numOfOccurrencesGuess > numOfOccurrencesSecret &&
                    letterPosition > numOfOccurrencesSecret) {
                    box.classList.add('empty');
                } else {
                    if (lettre === this.state.secret[i]) {
                    box.classList.add('correct');
                    } else if (this.state.secret.includes(lettre)) {
                    box.classList.add('wrong');
                    } else {
                    box.classList.add('empty');
                    }
                }
            }, ((i + 1) * dure) / 2);
            box.classList.add('flip')
            box.style.animationDelay = `${i * dure/2}ms`
        }

        setTimeout(() => {
            let message = '';
            let gagne = false;
            if (this.state.secret === mot) { 
                message ='Gagné ! vous avez trouve en ' + (this.state.currentRow) + ' essais';
                gagne = true;
            }else if(this.state.currentRow === this.nombreEssai) {
                message = `Perdu ! Le mot était ${this.state.secret}`;
                gagne = false;
            }
            
            if (this.state.secret === mot || this.state.currentRow === this.nombreEssai) {
                this.#printScore(message);
                this.reload();
                this.#wiktionarySource();
                this.#shareScoreOnTwitter(gagne);
            }
        }, dure * 3);
    }

    /**
     * 
     * @param {string} word 
     * @param {string} letter 
     * @returns {int}
     * retourne le nombre d'occurence de la lettre dans le mot
     */
    #getNumOfOccurrencesInWord(word, letter) {
        let result = 0;
        for (let i = 0; i < word.length; i++) {
        if (word[i] === letter) {
            result++;
        }
        }
        return result;
    }
    
    /**
     * 
     * @param {string} word 
     * @param {string} letter 
     * @param {int} position 
     * @returns {int}
     * retourne le nombre d'occurence de la lettre dans le mot jusqu'à la position donnée
     */
    #getPositionOfOccurrence(word, letter, position) {
        let result = 0;
        for (let i = 0; i <= position; i++) {
        if (word[i] === letter) {
            result++;
        }
        }
        return result;
    }
    

    /**
     * @returns {string} retourne le mot courant
     */
    getCurrentWord() {
        return this.state.grid[this.state.currentRow].reduce((acc, lettre) => acc + lettre);
    }

    /**
     * 
     * stop le jeu et affiche le score
    */
    #printScore(msg) {
        const container = document.getElementById('game');
        const score = document.createElement('div');
        score.className = 'score';
        score.textContent = msg;
        const button = document.createElement('button');
        button.textContent = 'Rejouer';
        container.appendChild(score);
    }

    /**
     * 
     * Cree le boutton de definition
     */
    #wiktionarySource() {
        const button = document.createElement('button');
        button.textContent = 'Definition';
        button.onclick = () => window.open(`https://fr.wiktionary.org/wiki/${this.state.secret}`, '_blank');
        const container = document.getElementById('game');
        container.appendChild(button)
    }

    /**
     * 
     * @param {boolean} gagne 
     * creer un bouton pour partager le score sur twitter (pas X)
    */
    #shareScoreOnTwitter(gagne) {
        const score = this.state.currentRow;
        let url = ``;
        if (gagne)  {
            url = `https://twitter.com/intent/tweet?text=J'ai%20trouvé%20le%20mot%20en%20${score}%20essai`;
        } else {
            url = `https://twitter.com/intent/tweet?text=J'ai%20perdu%20le%20mot%20était%20${this.state.secret}`;
        }
        const button = document.createElement('button');
        button.textContent = 'Partager sur Twitter';
        button.onclick = () => window.open(url, '_blank');
        const container = document.getElementById('game');
        container.appendChild(button);
        document.body.onkeydown = () => {};
    }

    /**
     * 
     * creer un bouton pour rejouer
     */
    reload() {
        const button = document.createElement('button');
        button.textContent = 'Rejouer';
        button.onclick = () => window.location.reload();
        const container = document.getElementById('game');
        container.appendChild(button);

    }

    /**
     * 
     * dessine la grille et lance le jeu
     */
    startGame() {
        const container = document.getElementById('game');
        console.log(this.#mot);
        this.#drawGrid(container, this.nombreEssai); 
        this.#clavier();

        //TODO: Appeler le mode de jeu
    }

    endGame(){
        //TODO: Deplacer des morceaux du code provenant de la methode reveal() ici
    }
}