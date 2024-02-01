//import { realDictionary } from './Dico/dictionnaire.js';
const dicoTest = [
    'proue','zebre','pomme',
    'chats','chien','singe',
    'tigre','fleur','plage',
    'arabe','arbre','table'
];
//Changer ici pour changer le dico
//           \/\/
const dico = dicoTest;
const Nombredessai = 6;
const mots = dico[Math.floor(Math.random() * dico.length)];
/*
Mot = choixMot();
function choixMot() {
    const mot = '';
    while (mot.length < 5 || mot.length > 10) {
        mot = dico[Math.floor(Math.random() * dico.length)];
    }
    return mot;
}
*/
const state = {
    secret: mots,
    grid: Array(Nombredessai)
        .fill()
        .map(() => Array(mots.length).fill('')),
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
function clavier() {
    document.body.onkeydown = (e) => {
        console.log(e.key);
        const lettre = e.key;
        let mot = '';
        if (lettre === 'Enter') {
            if (state.currentCol === 5){
                mot = getCurrentWord();
                if (isWord(mot)) {
                    state.currentCol = 0;
                    reveal(mot);
                    state.currentRow++;
                }else{
                    alert('Ce n\'est pas un mot');
                }
            }
        } else if (lettre === 'Backspace') {
            supprLettre();
        } else if (isLetter(lettre)) {
            addLettre(lettre);
        }
        update();
    }
}

/**
 * 
 * @param {string} mot 
 * @returns {boolean}
 * return true si le mot est dans le dictionnaire
 */
function isWord(mot) {return dico.includes(mot);}

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
    console.log('Colonne: n°'+ state.currentCol);
    console.log('Ligne: n°'+ state.currentRow);
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
 * révèle le mot
 */
function reveal(mot) {
    const dure = 500; //ms
    const row = state.currentRow;
    //animation de révélation
    for (let i = 0; i < mot.length; i++) {
        const box = document.getElementById(`box-${row}-${i}`);
        const lettre = box.textContent;
        const numOfOccurrencesSecret = getNumOfOccurrencesInWord(state.secret,lettre);
        const numOfOccurrencesGuess = getNumOfOccurrencesInWord(mot, lettre);
        const letterPosition = getPositionOfOccurrence(mot, lettre, i);
      
        setTimeout(() => {
            if (numOfOccurrencesGuess > numOfOccurrencesSecret &&
                letterPosition > numOfOccurrencesSecret) {
                box.classList.add('empty');
            } else {
                if (lettre === state.secret[i]) {
                  box.classList.add('correct');
                } else if (state.secret.includes(lettre)) {
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
        if (state.secret === mot) {
            printScore('Gagné ! vous avez trouve en ' + (state.currentRow) + ' essais');
            shareScoreOnTwitter(true);
            reload();
        } if (state.currentRow === Nombredessai) {
            printScore(`Perdu ! Le mot était ${state.secret}`);
            shareScoreOnTwitter(false);
            reload();
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
   * retourne le nombre d'occurence de la lettre dans le mot jusqu'à la position donnée
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
 * stop le jeu et affiche le score
*/
function printScore(msg) {
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
 * @param {boolean} gagne 
 * creer un bouton pour partager le score sur twitter (pas X)
*/
function shareScoreOnTwitter(gagne) {
    const score = state.currentRow;
    let url = ``;
    if (gagne)  {
        url = `https://twitter.com/intent/tweet?text=J'ai%20trouvé%20le%20mot%20en%20${score}%20essai`;
    } else {
        url = `https://twitter.com/intent/tweet?text=J'ai%20perdu%20le%20mot%20était%20${state.secret}`;
    }
    console.log(url);
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
function reload() {
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
function start() {
    const container = document.getElementById('game');
    console.log(state.secret);
    drawGrid(container, Nombredessai);
    clavier();
}

start();