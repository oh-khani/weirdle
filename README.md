# Weirdle

Un jeu de devinettes de mots français inspiré de Wordle.

## Fonctionnalités

- Plusieurs modes de jeu (Classique, Chronométré, Invisible)
- Dictionnaire français avec des mots de 5 lettres
- Définitions des mots via Larousse
- Partage de score sur Twitter

## Limitations

- Le classement n'est pas disponible (pas de base de données)
- La personnalisation du profil n'est pas disponible (pas de base de données)
- La progression du jeu n'est pas sauvegardée entre les sessions

## Démarrage Rapide

1. Assurez-vous d'avoir Docker installé sur votre système

2. Clonez le dépôt :
```bash
git clone <url-du-dépôt>
cd weirdle
```

3. Lancez le jeu :
```bash
docker-compose up
```

4. Ouvrez votre navigateur et allez à :
```
http://localhost:8080
```

## Modes de Jeu

- **Classique** : Gameplay standard de Wordle
- **Chronométré** : Course contre la montre
- **Invisible** : Les lettres disparaissent après les avoir tapées

## Comment Jouer

1. Devinez le mot français de 5 lettres
2. Vert : Lettre correcte à la bonne position
3. Jaune : Lettre correcte à la mauvaise position
4. Gris : Lettre absente du mot
5. Vous avez 6 tentatives pour deviner le mot

## Développement

Le jeu utilise :
- PHP 8.3
- Apache
- JavaScript
- JSON pour le stockage des mots (pas de base de données nécessaire)
