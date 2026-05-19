# php-docker-actions

Prosta aplikacja PHP do sprawdzianu z GitHub Actions, testów i Dockera.

## Endpointy
- `/` -> `hello from php app`
- `/health` -> powinno zwracać `ok`

## Wskazówka
W projekcie są celowe błędy. Część wyjdzie w lint/testach, a część dopiero podczas automatyzacji Dockera i Compose.
