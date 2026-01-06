# TP Kubernetes - Guide de Commandes

## 📋 Prérequis Vérifiés

✅ **Docker** : v28.5.1  
✅ **kubectl** : v1.34.1  
✅ **Cluster Kubernetes** : docker-desktop (Ready)

---

## Phase 1 - Dockerisation

### 1. Construire l'image (v1)

```powershell
docker build -t contact-app:v1 .
```

**Vérification** :
```powershell
docker images contact-app
```

### 2. Test local avec docker-compose (optionnel)

```powershell
docker-compose up -d
```

Accès : http://localhost:8000

**Arrêt** :
```powershell
docker-compose down
```

---

## Phase 2 - Déploiement Kubernetes

### 1. Créer le namespace

```powershell
kubectl apply -f k8s/namespace.yaml
kubectl get namespaces
```

### 2. Déployer MySQL

```powershell
kubectl apply -f k8s/mysql-secret.yaml -n laravel-app
kubectl apply -f k8s/mysql-pvc.yaml -n laravel-app
kubectl apply -f k8s/mysql-deployment.yaml -n laravel-app
kubectl apply -f k8s/mysql-service.yaml -n laravel-app
```

**Vérification** :
```powershell
kubectl get pods -n laravel-app
kubectl get svc -n laravel-app
```

### 3. Déployer Laravel

```powershell
kubectl apply -f k8s/laravel-secret.yaml -n laravel-app
kubectl apply -f k8s/laravel-configmap.yaml -n laravel-app
kubectl apply -f k8s/laravel-deployment.yaml -n laravel-app
kubectl apply -f k8s/laravel-service.yaml -n laravel-app
```

**Attendre que les pods soient Ready** :
```powershell
kubectl get pods -n laravel-app -w
```

### 4. Exécuter les migrations

```powershell
# Récupérer le nom d'un pod Laravel
kubectl get pods -n laravel-app

# Exécuter les migrations
kubectl exec <laravel-pod-name> -n laravel-app -- php artisan migrate --force
```

### 5. Fixer les permissions storage (si nécessaire)

```powershell
kubectl exec <laravel-pod-name> -n laravel-app -- chmod -R 777 /var/www/html/storage
```

### 6. Test de l'application

**Via NodePort** : http://localhost:30080

```powershell
curl http://localhost:30080
```

---

## Phase 3 - Cycle de Vie (Rolling Update)

### 1. Préparer la version 2

**Remplacer welcome.blade.php** :
```powershell
Copy-Item resources\views\welcome-v2.blade.php resources\views\welcome.blade.php -Force
```

### 2. Builder l'image v2

```powershell
docker build -t contact-app:v2 .
```

**Vérification** :
```powershell
docker images contact-app
```

### 3. Lancer le Rolling Update

```powershell
kubectl set image deployment/laravel-deployment laravel=contact-app:v2 -n laravel-app
```

### 4. Observer le déploiement progressif

```powershell
# Voir le statut du rollout
kubectl rollout status deployment/laravel-deployment -n laravel-app

# Observer les pods (nouveaux pods créés, anciens supprimés)
kubectl get pods -n laravel-app -w
```

### 5. Vérifier la nouvelle version

```powershell
curl http://localhost:30080
```

Ou ouvrir dans le navigateur: http://localhost:30080  
→ Doit afficher **"VERSION 2 🚀"** avec un fond violet

---

## Phase 4 - Rollback

### 1. Voir l'historique des déploiements

```powershell
kubectl rollout history deployment/laravel-deployment -n laravel-app
```

### 2. Effectuer un Rollback vers v1

```powershell
kubectl rollout undo deployment/laravel-deployment -n laravel-app
```

### 3. Observer le rollback

```powershell
kubectl rollout status deployment/laravel-deployment -n laravel-app
kubectl get pods -n laravel-app -w
```

### 4. Vérifier le retour à v1

```powershell
curl http://localhost:30080
```

Doit afficher la page Laravel d'origine

---

## Debug et Logs

### Voir les logs d'un pod

```powershell
kubectl logs <pod-name> -n laravel-app
kubectl logs <pod-name> -n laravel-app --tail=50
```

### Décrire un pod (détails + événements)

```powershell
kubectl describe pod <pod-name> -n laravel-app
```

### Voir tous les événements

```powershell
kubectl get events -n laravel-app --sort-by='.lastTimestamp'
```

### Shell interactif dans un pod

```powershell
kubectl exec -it <pod-name> -n laravel-app -- /bin/bash
```

### Logs Laravel

```powershell
kubectl exec <pod-name> -n laravel-app -- cat storage/logs/laravel.log
```

---

## Commandes de Diagnostic

### État global

```powershell
kubectl get all -n laravel-app
kubectl get deployments -n laravel-app
kubectl get pods -n laravel-app
kubectl get svc -n laravel-app
kubectl get pvc -n laravel-app
```

### Ressources détaillées

```powershell
kubectl describe deployment laravel-deployment -n laravel-app
kubectl describe deployment mysql-deployment -n laravel-app
kubectl describe service laravel-service -n laravel-app
```

---

## Nettoyage

### Supprimer toutes les ressources

```powershell
kubectl delete -f k8s/ -n laravel-app
kubectl delete namespace laravel-app
```

### Supprimer les images Docker

```powershell
docker rmi contact-app:v1 contact-app:v2
```

---

## Captures d'écran à Prendre pour le Rapport

1. ✅ **Docker images** : `docker images contact-app`
2. ✅ **Namespace** : `kubectl get namespaces`
3. ✅ **Pods Running** : `kubectl get pods -n laravel-app`
4. ✅ **Services** : `kubectl get svc -n laravel-app`
5. ✅ **Deployments** : `kubectl get deployments -n laravel-app`
6. ✅ **Application v1** : http://localhost:30080 (page Laravel standard)
7. ✅ **Rolling Update en cours** : `kubectl rollout status...` ou `kubectl get pods -w`
8. ✅ **Application v2** : http://localhost:30080 (fond violet "VERSION 2")
9. ✅ **Rollout history** : `kubectl rollout history...`
10. ✅ **Rollback** : `kubectl rollout undo...`
11. ✅ **Application après rollback** : http://localhost:30080 (retour v1)
12. ✅ **Logs** : `kubectl logs <pod-name>`

---

## Résumé des fichiers créés

### Docker
- `Dockerfile` - Image Laravel PHP 8.2-apache
- `.dockerignore` - Optimisation build
- `docker-compose.yml` - Test local

### Kubernetes (dossier `k8s/`)
- `namespace.yaml` - Namespace laravel-app
- `mysql-secret.yaml` - Credentials MySQL
- `mysql-pvc.yaml` - Volume persistant MySQL (2Gi)
- `mysql-deployment.yaml` - Deployment MySQL (1 réplica)
- `mysql-service.yaml` - Service ClusterIP MySQL
- `laravel-secret.yaml` - APP_KEY Laravel
- `laravel-configmap.yaml` - Variables d'environnement Laravel
- `laravel-deployment.yaml` - Deployment Laravel (2 réplicas)
- `laravel-service.yaml` - Service NodePort Laravel (port 30080)
- `laravel-ingress.yaml` - Ingress (optionnel)

---

## Notes Importantes

> **Permissions storage** : Le Dockerfile corrigé crée automatiquement les répertoires `storage/framework/{sessions,views,cache}` avec les bonnes permissions.

> **imagePullPolicy** : `Never` dans le Deployment Laravel pour utiliser l'image locale.

> **Probes** : Temporairement désactivées pendant le debug, à réactiver en production.

> **Migrations** : Exécutées manuellement après déploiement avec `--force`.
