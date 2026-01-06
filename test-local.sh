#!/bin/bash

# Script de test local avant CI/CD
# Ce script vérifie que tous les tests passent en local avant de push vers GitHub

echo "=========================================="
echo "   Tests Locaux - Contact App"
echo "=========================================="
echo ""

# Couleurs pour le terminal
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Compteur d'erreurs
ERRORS=0

# 1. Vérification de la syntaxe PHP
echo "📋 Étape 1/4: Vérification de la syntaxe PHP..."
if find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \; 2>&1 | grep -q "Parse error"; then
    echo -e "${RED}❌ Erreurs de syntaxe PHP détectées!${NC}"
    ERRORS=$((ERRORS+1))
else
    echo -e "${GREEN}✅ Syntaxe PHP correcte${NC}"
fi
echo ""

# 2. Vérification des dépendances
echo "📦 Étape 2/4: Vérification des dépendances Composer..."
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}⚠️  Dossier vendor manquant. Installation des dépendances...${NC}"
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi
echo -e "${GREEN}✅ Dépendances Composer OK${NC}"
echo ""

# 3. Exécution des tests PHPUnit dans Docker
echo "🧪 Étape 3/4: Exécution des tests PHPUnit..."
if docker exec laravel-app php artisan test --testdox; then
    echo -e "${GREEN}✅ Tous les tests passent!${NC}"
else
    echo -e "${RED}❌ Des tests ont échoué!${NC}"
    ERRORS=$((ERRORS+1))
fi
echo ""

# 4. Vérification de la configuration Docker
echo "🐳 Étape 4/4: Vérification Docker..."
if docker ps | grep -q "laravel-app"; then
    echo -e "${GREEN}✅ Container Docker en cours d'exécution${NC}"
else
    echo -e "${RED}❌ Container Docker non démarré!${NC}"
    echo -e "${YELLOW}   Exécutez: docker-compose up -d${NC}"
    ERRORS=$((ERRORS+1))
fi
echo ""

# Résultat final
echo "=========================================="
if [ $ERRORS -eq 0 ]; then
    echo -e "${GREEN}✅ SUCCÈS: Tous les tests passent!${NC}"
    echo -e "${GREEN}   Vous pouvez push vers GitHub en toute sécurité.${NC}"
    exit 0
else
    echo -e "${RED}❌ ÉCHEC: $ERRORS erreur(s) détectée(s)${NC}"
    echo -e "${RED}   Corrigez les erreurs avant de push!${NC}"
    exit 1
fi
echo "=========================================="
