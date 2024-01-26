//import { testDictionary, realDictionary } from './Dico/dictionnaire.js';
const dicoTest = [
    'proue',
    'zebre',
    'pomme',
    'chats',
    'chien',
    'singe',
    'tigre',
    'fleur',
    'plage',
    'arabe'
];
//Changer ici pour changer le dico
//           \/\/
const dico = dicoTest;
const Nombredessai = 6;
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
    secret: dico[Math.floor(Math.random() * dico.length)],
    grid: Array(6)
        .fill()
        .map(() => Array(5).fill('')),
    currentRow: 0,
    currentCol: 0,
};


function update() {
    for (let i = 0; i < state.grid.length; i++) {
        for (let j = 0; j < state.grid[i].length; j++) {
            const box = document.getElementById(`box${i}${j}`);
            box.textContent = state.grid[i][j];
        }
    }
}

function drawBox(container, row, col, lettre='') {
    const box = document.createElement('div');
    box.className = 'box';
    box.id = `box-${row}-${col}`;
    box.textContent = lettre;
    container.appendChild(box);
    return box;
}

function drawGrid(container, nbessai = 6) {
    const longueur = state.secret.length;
    const grid = document.createElement('div');
    grid.className = 'grid';
    for (let row = 0; row < longueur; row++) {
        for (let col = 0; col < nbessai; col++) {
            drawBox(grid, row, col);
        }
    }
    container.appendChild(grid);
}

function clavier() {
    document.body.onkeydown = (e) => {
        console.log(e.key);
        const lettre = e.key;
        if (lettre === 'Enter') {
            const mot = getCurrentWord();
            console.log(`Le mots entre est `+ mot);
            if (isWord(mot)) {
                reveal(mot);
                state.currentRow++;
                state.currentCol = 0;
            }else{
                alert('Ce n\'est pas un mot');
            }
            if (lettre === 'Backspace') {
                supprLettre();
            }
            if (isLetter(lettre)) {
                addLettre(lettre);
            }
            update();
        }
    }
}

function isWord(mot) {return dico.includes(mot);}
function isLetter(lettre) {return lettre.length === 1 && lettre.match(/[a-z]/i);}
function addLettre(lettre) {
    if (state.currentCol === 5) return;
    state.grid[state.currentRow][state.currentCol] = lettre;
    state.currentCol++;    
}
function supprLettre() {
    if (state.currentCol === 0) return;
    state.grid[state.currentRow][state.currentCol - 1] = '';
    state.currentCol--;
}

function reveal(mot) {
    const row = state.currentRow;
    for (let i = 0; i < mot.length; i++) {
        const box = document.getElementById(`box${row}${i}`);
        const lettre = box.textContent;
        const durre = 500; //ms
        setTimeout(() => {
            if (lettre === box.secret[i]) {
                box.classList.add('correct');
            }else if (box.secret.includes(lettre)){
                box.classList.add('wrong');
            }else{
                box.classList.add('empty');
            }
        }, i * durre);
        box.classList.add('flip')
        box.style.animationDelay = `${i * durre/2}ms`
    }

    const Win = state.secret === mot;
    const loose = state.currentRow === state.grid.length;

    setTimeout(() => {
        if (Win) {
            alert('Bravo');
        }else if (loose) {
            alert(`Perdu!\nLe mot était ${state.secret}.`);
        }
    }, durre * mot.length);
}

function getCurrentWord() {
    return state.grid[state.currentRow].reduce((acc, lettre) => acc + lettre);
}

function start() {
    const container = document.getElementById('game');
    
    drawGrid(container, Nombredessai);
    clavier();
    console.log(state.secret);
}

start();