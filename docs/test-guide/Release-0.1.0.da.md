---
title: Test release 0.1.0
parent: Testvejledning
---

# {{ page.title }}

Se [Testvejledning](README.da.md) for generelle oplysninger om test af [Filmfolk].

Dette er den første release af Filmfolk, så derfor skal "det hele testes". Det er generelt en god ide at teste "det
hele" i forbindelse med en ny release.

## Oprettelse af profil (som administrator)

Test at du med succes kan gennemføre alle skridt i [Personvejledning](../person-management.da.md), dvs. at du som
personadministrator kan oprette og redigere profiler.

## Oprettelse af profil (udefra)

Test at du med succes kan gennemføre alle skridt i [Personvejledning](../users-manual.da.md), dvs. at en udefra kommende
bruger kan oprette en profil, at du, som administrator, kan godkende den og at brugeren efterfølgende kan tilgå sine
profil.

> [!TIP]
> Undervejs kan du med fordel bruge to forskellige browsere (eller et inkognitovindue) fordi du både skal være logget
> ind som administrator og som "almindelig" bruger.

Test at brugeren kan redigere sin profil.

## Visning af profiler

Test af

1. nye profiler dukker op på profillisten (<https://filmfolk.srvitkstgweb02.itkdev.dk/>)
2. kun aktive profiler vises på profillisten (<https://filmfolk.srvitkstgweb02.itkdev.dk/>)

[Filmfolk]: https://filmfolk.srvitkstgweb02.itkdev.dk/
