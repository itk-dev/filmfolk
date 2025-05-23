---
layout: default
title: Brugervejledning
---

{% include environment_helpers.html %}

# Brugervejledning for Filmfolk

## Grundlæggende navigation

{% if is_production %}
Velkommen til den officielle brugervejledning for Filmfolk. Denne vejledning er baseret på produktionsmiljøet.

For hjælp, kontakt os på [support@filmfolk.dk](mailto:support@filmfolk.dk).
{% endif %}

{% if is_staging %}
**Bemærk: Dette er staging-miljøet**

Denne vejledning beskriver funktioner, der muligvis stadig er under udvikling.
For support, kontakt udviklerne på [dev@filmfolk.dk](mailto:dev@filmfolk.dk).
{% endif %}

{% if is_test %}
**ADVARSEL: Dette er testmiljøet**

Denne dokumentation er kun til internt brug og test. Funktioner beskrevet her kan ændres.
{% endif %}

Besøg vores hjemmeside på [{{ env_url }}]({{ env_url }})


* [block-editor.da.md](block-editor.da.md)
* [menus.da.md](menus.da.md)
* [person-management.da.md](person-management.da.md)
* [roles.da.md](roles.da.md)
* [Brugervejledning](users-manual.da.md)
