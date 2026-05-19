# Sprawdzian — sekcja praktyczna

## Kontekst

Masz prostą aplikację HTTP napisaną w PHP. W repozytorium znajdują się:
- kod aplikacji,
- testy,
- `Dockerfile`,
- `docker-compose.yml`.

W projekcie są **celowe błędy**, które wyjdą dopiero podczas uruchamiania lintu, testów i automatyzacji Dockera.

## Twoje zadanie

Napisz **dwa workflow** GitHub Actions. Musisz poprawić błędy znajdujące się w repozytorium. Podaj komunikaty tych błędów.

### Workflow 1 — `ci.yml`
Utwórz plik `.github/workflows/ci.yml`.

Workflow ma:
- uruchamiać się na `pull_request`, `push` i `workflow_dispatch`,
- zawierać co najmniej trzy joby:
  1. `lint`,
  2. `test`,
  3. `docker_smoke`.

#### Wymagania dla `lint`
1. konfiguracja PHP przez gotową action (`shivammathur/setup-php@v2`, użyj wersji PHP 8.3 oraz w parametrze `tools` ustaw wartość `composer`),
2. instalacja zależności (`composer install --no-interaction --no-progress`),
3. uruchomienie lintu (`composer lint`).

#### Wymagania dla `test`
1. job ma zależeć od `lint`,
2. uruchomienie testów (`composer test:junit`),
3. wygenerowanie raportu JUnit do pliku `build/junit.xml` (generuje się automatycznie po powyższej komendzie, może być potrzebne wcześniejsze utworzenie katalogu `build`, jeśli wyrzuci błąd),
4. wysłanie raportu jako artefakt.

#### Wymagania dla `docker_smoke`
1. job ma zależeć od `test`,
2. job ma uruchamiać się tylko dla:
  - `pull_request`, albo
  - `push` do `main`,
3. zbudowanie obrazu Dockera,
4. uruchomienie kontenera przez `docker run`,
5. smoke test endpointu `http://localhost:8080/health`,
6. zawsze zapisać logi kontenera i wynik `docker ps -a` do plików (`komenda &> sciezka_do_pliku || true`),
7. zawsze wysyłać te pliki jako artefakt,
8. zawsze cleanup przez `docker rm -f nazwa || true`.

### Workflow 2 — `release-sim.yml`
Utwórz plik `.github/workflows/release-sim.yml`.

Workflow ma:
1. uruchamiać się na `push` oraz `workflow_dispatch`,
2. wykonywać główny job tylko wtedy, gdy:
  - event to `workflow_dispatch`, albo
  - jest to `push` do branchu `main`,
3. użyć `docker/setup-buildx-action` do zsetupowania sterownika buildx (nie ustawiaj żadnych parametrów w tej akcji),
4. użyć `docker/build-push-action` do zbudowania obrazu i wyeksportowania go do pliku `.tar` (ustaw `push` na `false` i `outputs` na `type=docker,dest=sciezka_do_obrazu.tar`,
5. spakować obraz do `.tar.gz` (`gzip -c sciezka_do_obrazu.tar > sciezka_do_obrazu.tar.gz`),
6. wysłać go jako artifact,
7. uruchomić aplikację przez `docker compose up -d --build`,
8. wykonać smoke test endpointu `http://localhost:8080/health`,
9. zawsze wysłać logi Compose jako artifact,
10. zawsze cleanup przez `docker compose down -v || true`

## Co powinieneś naprawić w projekcie
W projekcie są co najmniej cztery problemy:
1. jeden powoduje błąd lintu,
2. jeden powoduje błąd testów,
3. jeden jest związany z uruchomieniem kontenera z obrazu Docker,
4. jeden jest związany z konfiguracją Docker Compose.
