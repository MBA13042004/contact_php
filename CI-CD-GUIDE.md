# 🚀 Guide CI/CD - Contact App

## 📋 Vue d'ensemble

Ce projet utilise un workflow CI/CD automatisé avec GitHub Actions pour:
- ✅ Exécuter des tests automatiques
- 🐳 Builder et pusher l'image Docker vers Docker Hub
- 🔒 Utiliser des secrets sécurisés pour Docker Hub

---

## 🔧 Configuration des Secrets GitHub

Avant de pouvoir utiliser le CI/CD, vous devez configurer les secrets dans votre repository GitHub:

1. Allez dans votre repository GitHub
2. Cliquez sur **Settings** → **Secrets and variables** → **Actions**
3. Ajoutez les secrets suivants:

| Secret Name | Description | Valeur |
|------------|-------------|---------|
| `DOCKER_USERNAME` | Votre nom d'utilisateur Docker Hub | Votre username |
| `DOCKER_PASSWORD` | Votre mot de passe ou token Docker Hub | Votre password/token |

---

## 🧪 Tests en Local (OBLIGATOIRE avant de push)

### Windows (PowerShell)

```powershell
# Exécuter le script de test
.\test-local.ps1
```

### Linux/Mac (Bash)

```bash
# Rendre le script exécutable
chmod +x test-local.sh

# Exécuter le script de test
./test-local.sh
```

### Tests manuels dans Docker

```bash
# Exécuter tous les tests
docker exec laravel-app php artisan test --testdox

# Exécuter un test spécifique
docker exec laravel-app php artisan test --filter=NomDuTest

# Vérifier la syntaxe PHP
find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \;
```

---

## 🔄 Workflow CI/CD

Le workflow s'exécute automatiquement sur:
- **Push** vers les branches `main`, `master`, ou `develop`
- **Pull Request** vers ces mêmes branches
- **Manuellement** via l'onglet Actions de GitHub

### Étapes du Workflow

#### 1️⃣ Job: Tests Laravel
- ✅ Checkout du code
- ✅ Installation de PHP 8.2
- ✅ Installation des dépendances Composer
- ✅ Configuration de la base de données MySQL
- ✅ Exécution des migrations
- ✅ Vérification de la syntaxe PHP
- ✅ Exécution des tests PHPUnit

#### 2️⃣ Job: Build & Push Docker
- 🐳 Build de l'image Docker
- 🔒 Login sur Docker Hub (avec secrets)
- 📤 Push de l'image vers Docker Hub
- 🏷️ Tagging automatique (latest + SHA)

**Note:** Ce job s'exécute UNIQUEMENT si:
- Les tests passent avec succès
- Le push est sur la branche `main` ou `master`

---

## 📊 Vérifier les Tests sur GitHub

1. Allez dans l'onglet **Actions** de votre repository
2. Vous verrez tous les workflows exécutés
3. Cliquez sur un workflow pour voir les détails
4. Les ✅ verts indiquent le succès, les ❌ rouges les échecs

---

## 🐳 Utiliser l'Image Docker Buildée

Une fois le workflow terminé, votre image est disponible sur Docker Hub:

```bash
# Pull l'image depuis Docker Hub
docker pull VOTRE_USERNAME/contact-app:latest

# Ou utiliser le tag avec le SHA
docker pull VOTRE_USERNAME/contact-app:main-abc1234
```

---

## 🛠️ Commandes Utiles

### Vérifier le statut Docker local

```bash
# Voir les containers en cours
docker ps

# Voir les logs
docker-compose logs -f app

# Redémarrer les services
docker-compose restart
```

### Exécuter des commandes Laravel dans Docker

```bash
# Migrations
docker exec laravel-app php artisan migrate

# Seeders
docker exec laravel-app php artisan db:seed

# Cache clear
docker exec laravel-app php artisan cache:clear
```

---

## 🔍 Résolution des Problèmes

### Les tests échouent localement?

1. Vérifiez que Docker est démarré: `docker ps`
2. Vérifiez les logs: `docker-compose logs`
3. Redémarrez les services: `docker-compose down && docker-compose up -d`
4. Exécutez les migrations: `docker exec laravel-app php artisan migrate`

### Le build Docker échoue sur GitHub?

1. Vérifiez que les secrets sont bien configurés
2. Vérifiez les logs dans l'onglet Actions
3. Assurez-vous que le Dockerfile est valide

### Les tests passent en local mais pas sur GitHub?

1. Vérifiez les différences d'environnement
2. Assurez-vous que `.env.example` existe
3. Vérifiez que toutes les dépendances sont dans `composer.json`

---

## 📝 Checklist avant chaque Push

- [ ] Les tests passent en local (`.\test-local.ps1` ou `./test-local.sh`)
- [ ] Le code est committé: `git add .` et `git commit -m "message"`
- [ ] Push vers GitHub: `git push origin main`
- [ ] Vérifier le workflow sur GitHub Actions
- [ ] Vérifier que l'image est sur Docker Hub (si push sur main/master)

---

## 🎯 Bonnes Pratiques

1. **Toujours tester en local** avant de push
2. **Utiliser des branches** pour les nouvelles fonctionnalités
3. **Créer des Pull Requests** pour révision de code
4. **Ne jamais pousser directement sur main** sans tests
5. **Vérifier les logs** en cas d'échec du workflow

---

## 📞 Support

En cas de problème, vérifiez:
- Les logs Docker: `docker-compose logs`
- Les logs GitHub Actions dans l'onglet Actions
- La configuration des secrets GitHub
- Le fichier `.env.example`

---

**🎉 Bon développement!**
