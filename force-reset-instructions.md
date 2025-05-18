# Instructions pour synchroniser les fichiers entre Mac et Windows

Ce document contient les étapes à suivre pour résoudre les problèmes de synchronisation entre les différents systèmes d'exploitation.

## Pour tous les membres de l'équipe

### Configuration globale Git

1. **Sur Windows**:
   ```
   git config --global core.autocrlf false
   git config --global core.eol lf
   ```

2. **Sur Mac/Linux**:
   ```
   git config --global core.autocrlf input
   git config --global core.eol lf
   ```

### Réinitialisation de votre projet

**Attention**: Cette procédure va réinitialiser tous vos fichiers locaux. Assurez-vous d'abord de commit/stash tous vos changements importants.

1. **Sauvegardez vos modifications non-committées**:
   ```
   git stash
   ```

2. **Récupérez les derniers changements**:
   ```
   git pull
   ```

3. **Réinitialisez le cache git**:
   ```
   git rm --cached -r .
   ```

4. **Récupérez tous les fichiers avec les bonnes fins de ligne**:
   ```
   git reset --hard
   ```

5. **Récupérez vos modifications (si vous avez fait un stash)**:
   ```
   git stash pop
   ```

## Cas particuliers

### Pour les utilisateurs Windows qui continuent à avoir des problèmes

Si vous utilisez des éditeurs comme Notepad++ ou Visual Studio Code, configurez-les pour utiliser les fins de ligne LF:

- **Visual Studio Code**:
  1. Ouvrez le fichier dans VSCode
  2. Regardez dans la barre d'état en bas à droite
  3. Cliquez sur "CRLF" et changez en "LF"
  4. Dans les paramètres, modifiez `files.eol` en `\n`

- **Notepad++**:
  1. Édition > Préférences > Nouveau document
  2. Dans "Format", sélectionnez "Unix (LF)"

### Le '.gitattributes' et '.gitignore'

Les fichiers `.gitattributes` et `.gitignore` devraient normaliser tout automatiquement, mais ils ne s'appliquent qu'aux nouveaux fichiers ou aux fichiers modifiés. C'est pourquoi la réinitialisation est nécessaire.

## Vérification

Pour vérifier que les fins de ligne sont correctes:
```
git ls-files --eol | grep -E 'php|js|html'
```

Vous devriez voir `i/lf w/lf` pour tous les fichiers, ce qui signifie qu'ils sont correctement configurés.

## Problèmes spécifiques

Si un fichier pose particulièrement problème, forcez sa normalisation:
```
dos2unix path/to/problematic/file.php
git add path/to/problematic/file.php
git commit -m "Fix line endings"
git push
``` 