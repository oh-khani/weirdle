//import json motMystere
import data from './Dico/dictionnaire.json' with { type: 'json' };

const dicoTest = [
    'proue','zebre','pomme',
    'chats','chien','singe',
    'tigre','fleur','plage',
    'arabe','arbre','table'
  ];

//Changer ici pour changer le dico (dicoTest ou data.motMystere)
//           \/\/
const dico = data.mots;
const nbEssais = 6;
const motMystere = dico[Math.floor(Math.random() * dico.length)].toLowerCase();
const gameDiv = document.getElementById("game");

const state = {
    secret: motMystere,
    grid: Array(nbEssais)
        .fill()
        .map(() => Array(motMystere.length).fill('')),
    currentRow: 0,
    currentCol: 0,
};

/**
 * 
 * Met à jour la grille de jeu avec les lettres entrées par le joueur
 */
function update() {
    for (let i = 0; i < state.grid.length; i++) {
        for (let j = 0; j < state.grid[i].length; j++) {
            const box = document.getElementById(`box-${i}-${j}`);
            box.textContent = state.grid[i][j];
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
function drawBox(container, row, col, lettre='') {
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
function drawGrid(container, nbessai = 6) {
    const longueur = state.secret.length;
    const grid = document.createElement('div');
    grid.className = 'grid';
    for (let row = 0; row < longueur+1; row++) {
        for (let col = 0; col < nbessai-1; col++) {
            drawBox(grid, row, col);
        }
    }
    container.appendChild(grid);
}

/**
 * 
 * Lis les touches du clavier
 */
function clavier(touche) {

    const lettre = touche.key;
    let mot = '';

    if (lettre === 'Enter' || lettre === "⏎") {
        if (state.currentCol === 5){
            mot = getCurrentWord();
            if (isWord(mot)) {
                state.currentCol = 0;
                reveal(mot);
                state.currentRow++;
            }else if (mot  === 'hideo') {
                let counter = 0;
                document.body.style.backgroundImage = 
                    "url('./src/img/hideo-kojima-credits.gif')";
                setInterval(() => {
                    counter++;
                    if (counter >= 3){
                        return;
                    }
                }, 1000);
                document.body.style.backgroundImage = none;
            }else{
                alert('Ce n\'est pas un mot');
            }
        }
    } else if (lettre === 'Backspace' || lettre === "⌫") {
        supprLettre();
    } else if (isLetter(lettre)) {
        addLettre(lettre.toLowerCase());
    }
    update();
}

/**
 * Affiche l'interface clavier pour pouvoir jouer avec la souris
 * et voir quelles lettres ont déjà été utilisées
 */
function interfaceClavier(){
    
    let keyboardContainer = document.getElementById("keyboard");

    let keyboard = [
        ["A", "Z", "E", "R", "T", "Y", "U", "I", "O", "P", "⌫"],
        ["Q", "S", "D", "F", "G", "H", "J", "K", "L", "M", "⏎"],
        ["W", "X", "C", "V", "B", "N", "😜", "😂", "😭", "🥳", "🥴"]
    ];

    for (let i = 0; i < keyboard.length; i++){
        let currentLigne = keyboard[i];
        let ligneClavier = document.createElement("div");
        ligneClavier.classList.add("keyboard-row");

        for (let j = 0; j < currentLigne.length; j++){
            let toucheClavier = document.createElement("div");

            let touche = currentLigne[j];
            toucheClavier.textContent = touche;

            if (touche === "⏎"){
                toucheClavier.setAttribute("id", "Enter");
                toucheClavier.classList.add("enter-key-tile");
                toucheClavier.classList.add("keytile");
            } else if (touche === "⌫"){
                toucheClavier.setAttribute("id", "Backspace");
                toucheClavier.classList.add("backspace-key-tile");
                toucheClavier.classList.add("keytile");
            } else if ("A" <= touche && touche <= "Z"){
                toucheClavier.setAttribute("id", "Key" + touche);
                toucheClavier.classList.add("keytile");
                
            } else {
                toucheClavier.setAttribute("id", "Emoji" + (j-5));
                toucheClavier.classList.add("keytile");
            }
            toucheClavier.addEventListener("click", processKey);

            ligneClavier.appendChild(toucheClavier);
        }
        keyboardContainer.appendChild(ligneClavier);
    }
    document.addEventListener("keyup", clavier);
}

/* S'utilise avec interfaceClavier() */
function processKey(){
    let lettre = {"key" : this.textContent};
    clavier(lettre);
}


/**
 * 
 * @param {string} mot 
 * @returns {boolean}
 * return true si le mot est dans le dictionnaire
 */
function isWord(mot) {return dico.includes(mot.toUpperCase());}

/**
 * 
 * @param {string} lettre 
 * @returns {boolean}
 * return true si la lettre est dans l'alphabet
 */
function isLetter(lettre) {return lettre.length === 1 && lettre.match(/[a-z]/i);}

/**
 * 
 * @param {string} lettre 
 * ajoute la lettre dans la grille
 */
function addLettre(lettre) {
    if (state.currentCol === 5) {return;    }
    state.grid[state.currentRow][state.currentCol] = lettre;
    state.currentCol++;
}

/**
 * 
 * supprime la lettre courante de la grille
 */
function supprLettre() {
    if (state.currentCol === 0) return;
    state.grid[state.currentRow][state.currentCol - 1] = '';
    state.currentCol--;
}

/**
 * 
 * @param {string} mot 
 * Affiche dans la grille le mot saisi par l'utilisateur
 */
function reveal(mot) {
    const dure = 500; //ms
    const row = state.currentRow;
    //animation de révélation
    for (let i = 0; i < mot.length; i++) {
        const box = document.getElementById(`box-${row}-${i}`);
        const lettre = box.textContent;
        
        const toucheClavier = document.getElementById("Key" + lettre.toUpperCase());

        const numOfOccurrencesSecret = getNumOfOccurrencesInWord(state.secret,lettre);
        const numOfOccurrencesGuess = getNumOfOccurrencesInWord(mot, lettre);
        const letterPosition = getPositionOfOccurrence(mot, lettre, i);
      
        setTimeout(() => {
            if (numOfOccurrencesGuess > numOfOccurrencesSecret &&
                letterPosition > numOfOccurrencesSecret) {
                box.classList.add('empty');
                toucheClavier.classList.add("empty");
            } else {
                if (lettre === state.secret[i]) {
                  box.classList.add('correct');
                  toucheClavier.classList.remove("wrong");
                  toucheClavier.classList.add("correct");
                } else if (state.secret.includes(lettre)) {
                  box.classList.add('wrong');
                  toucheClavier.classList.add("wrong");
                } else {
                  box.classList.add('empty');
                  toucheClavier.classList.add("empty");
                }
            }
        }, ((i + 1) * dure) / 2);
        box.classList.add('flip')
        box.style.animationDelay = `${i * dure/2}ms`
    }

    setTimeout(() => {
        let message = '';
        let gagne = null;
        if (state.secret === mot) { 
            message ='Gagné ! Vous avez trouvé en ' + (state.currentRow) + ' essais';
            gagne = true;
        }else if(state.currentRow === nbEssais) {
            message = `Perdu ! Le mot était ${state.secret}`;
            gagne = false;
        }
        
        if (state.secret === mot || state.currentRow === nbEssais) {
            printScore(message);
            reload();
            wiktionarySource();
            shareScoreOnTwitter(gagne);
        }
    }, dure * 3);
}

/**
 * 
 * @param {string} word 
 * @param {string} letter 
 * @returns {int}
 * Retourne le nombre d'occurence de la lettre dans le mot
 */
function getNumOfOccurrencesInWord(word, letter) {
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
   * Retourne le nombre d'occurence de la lettre dans le mot jusqu'à la position donnée
   */
  function getPositionOfOccurrence(word, letter, position) {
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
function getCurrentWord() {
    return state.grid[state.currentRow].reduce((acc, lettre) => acc + lettre);
}

/**
 * 
 * Stop le jeu et affiche le score
*/
function printScore(msg) {
    const container = document.getElementById('score');
    const score = document.createElement('div');
    score.className = 'score';
    score.textContent = msg;
    container.appendChild(score);
}

/**
 * 
 * Crée le bouton pour aller voir la définition sur Wiktionary (le mot peut ne pas exister sur Wiktionary)
 */
function wiktionarySource() {
    const button = document.createElement('button');
    button.type = "button";
    button.textContent = 'Définition';
    button.onclick = () => window.open(`https://fr.wiktionary.org/wiki/${state.secret}`, '_blank');
    const container = document.getElementById('button-container');
    container.appendChild(button)
}

/**
 * 
 * @param {boolean} gagne 
 * Crée un bouton pour partager le score sur Twitter (pas X)
*/
function shareScoreOnTwitter(gagne) {
    const score = state.currentRow;
    let url = ``;
    if (gagne)  {
        url = `https://twitter.com/intent/tweet?text=J'ai%20trouvé%20le%20mot%20en%20${score}%20essai`;
    } else {
        url = `https://twitter.com/intent/tweet?text=J'ai%20perdu%20le%20mot%20était%20${state.secret}`;
    }
    const button = document.createElement('button');
    button.type = "button";
    button.textContent = 'Partager sur Twitter';
    button.onclick = () => window.open(url, '_blank');
    const container = document.getElementById('button-container');
    container.appendChild(button);
    document.body.onkeydown = () => {};
}

/**
 * 
 * Crée un bouton pour rejouer
 */
function reload() {
    const button = document.createElement('button');
    button.type = "button";
    button.textContent = 'Rejouer';
    button.onclick = () => window.location.reload();
    const container = document.getElementById('button-container');
    container.appendChild(button);

}

/**
 * 
 * dessine la grille et lance le jeu
 */
function start() {
    console.log(motMystere); // Pour test
    drawGrid(gameDiv, nbEssais);
    interfaceClavier();
}

start();
