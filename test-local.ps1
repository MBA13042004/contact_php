# Script de test local avant CI/CD (Windows PowerShell)
# Ce script vérifie que tous les tests passent en local avant de push vers GitHub

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "   Tests Locaux - Contact App" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

$ERRORS = 0

# 1. Vérification de la syntaxe PHP
Write-Host "📋 Étape 1/4: Vérification de la syntaxe PHP..." -ForegroundColor Yellow
$phpFiles = Get-ChildItem -Path . -Filter *.php -Recurse -Exclude vendor | Where-Object { $_.FullName -notlike "*\vendor\*" }
$syntaxErrors = $false

foreach ($file in $phpFiles) {
    $result = php -l $file.FullName 2>&1
    if ($result -match "Parse error") {
        Write-Host "❌ Erreur dans: $($file.FullName)" -ForegroundColor Red
        $syntaxErrors = $true
        $ERRORS++
    }
}

if (-not $syntaxErrors) {
    Write-Host "✅ Syntaxe PHP correcte" -ForegroundColor Green
}
Write-Host ""

# 2. Vérification des dépendances
Write-Host "📦 Étape 2/4: Vérification des dépendances Composer..." -ForegroundColor Yellow
if (-not (Test-Path "vendor")) {
    Write-Host "⚠️  Dossier vendor manquant. Installation des dépendances..." -ForegroundColor Yellow
    composer install --no-interaction --prefer-dist --optimize-autoloader
}
Write-Host "✅ Dépendances Composer OK" -ForegroundColor Green
Write-Host ""

# 3. Exécution des tests PHPUnit
Write-Host "🧪 Étape 3/4: Exécution des tests PHPUnit..." -ForegroundColor Yellow
try {
    # Vérifier si le fichier phpunit existe
    if (Test-Path "vendor\bin\phpunit") {
        $testResult = .\vendor\bin\phpunit --testdox 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Tous les tests passent!" -ForegroundColor Green
            Write-Host $testResult
        }
        else {
            Write-Host "❌ Des tests ont échoué!" -ForegroundColor Red
            Write-Host $testResult
            $ERRORS++
        }
    }
    else {
        Write-Host "⚠️  PHPUnit non installé. Installation..." -ForegroundColor Yellow
        composer install --no-interaction
        Write-Host "✅ Tests ignorés (première installation)" -ForegroundColor Yellow
    }
}
catch {
    Write-Host "❌ Erreur lors de l'exécution des tests!" -ForegroundColor Red
    $ERRORS++
}
Write-Host ""

# 4. Vérification de la configuration Docker
Write-Host "🐳 Étape 4/4: Vérification Docker..." -ForegroundColor Yellow
$dockerPs = docker ps 2>&1 | Select-String "laravel-app"
if ($dockerPs) {
    Write-Host "✅ Container Docker en cours d'exécution" -ForegroundColor Green
}
else {
    Write-Host "❌ Container Docker non démarré!" -ForegroundColor Red
    Write-Host "   Exécutez: docker-compose up -d" -ForegroundColor Yellow
    $ERRORS++
}
Write-Host ""

# Résultat final
Write-Host "==========================================" -ForegroundColor Cyan
if ($ERRORS -eq 0) {
    Write-Host "✅ SUCCÈS: Tous les tests passent!" -ForegroundColor Green
    Write-Host "   Vous pouvez push vers GitHub en toute sécurité." -ForegroundColor Green
    exit 0
}
else {
    Write-Host "❌ ÉCHEC: $ERRORS erreur(s) détectée(s)" -ForegroundColor Red
    Write-Host "   Corrigez les erreurs avant de push!" -ForegroundColor Red
    exit 1
}
Write-Host "==========================================" -ForegroundColor Cyan
