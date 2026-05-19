# Sprawdzian — sekcja analizy kodu

Poniżej znajduje się fragment workflow. Odpowiedz na dwa pytania pod kodem.

```yaml
name: Broken CI

on:
  push:
    branches:
      - main
  pull_request:

jobs:
  lint:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - run: echo "lint ok"

  test:
    runs-on: ubuntu-latest
    needs: lint
    if: github.ref == 'refs/heads/main'
    steps:
      - uses: actions/checkout@v4
      - run: echo "tests ok"

  docker_smoke:
    runs-on: ubuntu-latest
    needs: test
    steps:
      - uses: actions/checkout@v4
      - run: docker compose up -d --build
      - run: curl -fsS http://localhost:8080/health
      - name: Upload logs
        uses: actions/upload-artifact@v4
        with:
          name: docker-logs
          path: compose.log
```

## Pytania

1. Czy job `test` uruchomi się podczas utworzenia pull requestu? Uzasadnij odpowiedź.
2. Podaj jeden problem logiczny w jobie `docker_smoke`, który utrudni diagnozę błędu, jeżeli smoke test się nie powiedzie.
