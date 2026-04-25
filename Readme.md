## Fitness-Tracker Application

Die Fitness-Tracker Application ist eine Anwendung, um Trainingsfortschritt im Fitness-Studio
aufzuzeichnen und zu planen. Sie stellt für eine einfache Verwaltung API-Endpunkte
und ein Easyadmin-Dashboard bereit. Die Funktionalitäten umfassen, einen Plan zu erstellen,
verschiedene Übungen zusammenzustellen, die mit unterschiedlichen Muskelgruppen arbeiten, ein Workout
zu erstellen und die Durchführung festzuhalten.

### Voraussetzungen zur Nutzung der Anwendung
- ddev
- docker
- eigene .env-Datei für das Projekt (zum Festhalten der Datenbankparameter)
- (yarn)

### 1. Installation und Setup

#### 1.1 Klonen des repository:

```git clone https://github.com/pascalrie/fitness-tracker.git```

#### 1.2 In das Backend des Repository navigieren:

```cd fitness-tracker/backend/```

#### Als Erstes sicherstellen, dass Docker gestartet ist!
**Zweitens:**
```ddev config```
(Bei den Fragen des ddev standardmäßig: "backend, public, symfony" antworten)

### 2. Datenbank generieren

#### 2.1 Erstellen/Kopieren einer (existierenden) .env-Datei in den backend-Ordner der Anwendung

**"Die Anwendung wurde unter mariadb-10.11.0 getestet"**

#### 2.2 Abhängigkeiten des Projektes via ```composer install``` installieren

#### 2.3 Erstellung der Datenbank im ddev
```ddev exec php bin/console doctrine:database:create```

#### 2.4 Update der Datenbank (um die Entitäten der Anwendung richtig abzubilden)

```ddev exec php bin/console doctrine:schema:update --force```

### 3. Nutzung:

#### 3.1. Mögliche Routen der API

##### 3.1.1 Zeigen dieser per Befehl
```ddev exec php bin/console debug:router```

#### 3.2 Auf Server im Browser zugreifen (nach ```ddev start```):
- https://backend.ddev.site/ 

#### 3.2.1 Zugriff auf das Easyadmin-Dashboard: /admin-Route nutzen
- https://backend.ddev.site/admin

### 4. Ausführen der Tests im Terminal (im Backend-Ordner):
```./vendor/bin/phpunit```

### 5. Frontend
- **funktioniert derzeit leider nicht in Verbindung mit Backend**
- aufrufbar unter:
```cd ../frontend```
- Abhängigkeiten installieren mit: 
```yarn install```
- Starten mit:
```yarn start```

### 6. TODOs
- CORS-Error bei Verbindung zwischen Front- und Backend lösen
- Integrationstests schreiben
- Docker-compose funktionsfähig machen