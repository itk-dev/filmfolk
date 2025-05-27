---
title: Siteadministration
parent: Brugervejledning
---

# {{ page.title }}

## E-mailskabeloner

En bruger med rollen Siteadministrator kan redigere e-mailskabeloner der bruges i forbindelse med profiloprettelse,
glemt adgangskode mm.

Skabelonerne findes via Indstillinger » Kontoindstillinger » Oversæt kontoindstillinger » Dansk » "Redigér" (alternativt
`/config/people/accounts/translate/da/edit`).

I skabelonerne kan følgende pladsholdere (Drupal kalder dem *tokens*) bruges

| Pladsholder                 | Beskrivelse                                                               | Eksempel                                                  |
|-----------------------------|---------------------------------------------------------------------------|-----------------------------------------------------------|
| `[site:name]`               | Sitets navn                                                               | `Filmfolk`                                                |
| `[site:url]`                | Sitets url                                                                | `https://filmfolk.filmpuljen.dk/`                         |
| `[site:url-brief]`          | Sitets korte url                                                          | `filmfolk.filmpuljen.dk`                                  |
| `[site:login-url]`          | Login urlen                                                               | `https://filmfolk.filmpuljen.dk/user/`                    |
| `[user:one-time-login-url]` | Engangsloginurl sendt via "Nulstil din adgangskode"                       | `https://filmfolk.filmpuljen.dk/user/reset/87/…`          |
| `[user:mail]`               | Brugerens e-mailadresse                                                   | `fotograf@eksempel.dk`                                    |
| `[user:account-name]`       | Brugerens kontonavn. Kontonavnet er det samme som brugeren e-mailadresse. | `fotograf@eksempel.dk`                                    |
| `[user:display-name]`       | Samme som brugerens e-mailadresse                                         | `fotograf@eksempel.dk`                                    |
| `[user:edit-url]`           | Url til redigering af brugers konto/profil                                | `https://filmfolk.filmpuljen.dk/user/2359/edit`           |
| `[user:cancel-url]`         | Url til bekræftelse af opsigelse af brugerkonto                           | `https://filmfolk.filmpuljen.dk/user/87/cancel/confirm/…` |

Bemærk at ikke alle pladsholdere giver mening i alle skabeloner, fx giver det ikke mening at bruge `[user:cancel-url]` i
skabelonen "Bekræftelse af opsigelse"
