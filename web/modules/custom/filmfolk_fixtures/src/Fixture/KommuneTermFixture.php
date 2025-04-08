<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\taxonomy\Entity\Term;

/**
 * Kommune term fixture.
 */
class KommuneTermFixture extends AbstractTaxonomyTermFixture {
  /**
   * {@inheritdoc}
   */
  protected static string $vocabularyId = 'kommune';

  /**
   * {@inheritdoc}
   */
  /**
   * Curl https://api.dataforsyningen.dk/kommuner | jq '.[].navn' --raw-output | sort | sed "s/^.*$/'\\0',/" | pbcopy.
   */
  protected static array $terms = [
    'Aabenraa',
    'Aalborg',
    'Aarhus',
    'Ærø',
    'Albertslund',
    'Allerød',
    'Assens',
    'Ballerup',
    'Billund',
    'Bornholm',
    'Brøndby',
    'Brønderslev',
    'Christiansø',
    'Dragør',
    'Egedal',
    'Esbjerg',
    'Faaborg-Midtfyn',
    'Fanø',
    'Favrskov',
    'Faxe',
    'Fredensborg',
    'Fredericia',
    'Frederiksberg',
    'Frederikshavn',
    'Frederikssund',
    'Furesø',
    'Gentofte',
    'Gladsaxe',
    'Glostrup',
    'Greve',
    'Gribskov',
    'Guldborgsund',
    'Haderslev',
    'Halsnæs',
    'Hedensted',
    'Helsingør',
    'Herlev',
    'Herning',
    'Hillerød',
    'Hjørring',
    'Høje-Taastrup',
    'Holbæk',
    'Holstebro',
    'Horsens',
    'Hørsholm',
    'Hvidovre',
    'Ikast-Brande',
    'Ishøj',
    'Jammerbugt',
    'Kalundborg',
    'Kerteminde',
    'København',
    'Køge',
    'Kolding',
    'Læsø',
    'Langeland',
    'Lejre',
    'Lemvig',
    'Lolland',
    'Lyngby-Taarbæk',
    'Mariagerfjord',
    'Middelfart',
    'Morsø',
    'Næstved',
    'Norddjurs',
    'Nordfyns',
    'Nyborg',
    'Odder',
    'Odense',
    'Odsherred',
    'Randers',
    'Rebild',
    'Ringkøbing-Skjern',
    'Ringsted',
    'Rødovre',
    'Roskilde',
    'Rudersdal',
    'Samsø',
    'Silkeborg',
    'Skanderborg',
    'Skive',
    'Slagelse',
    'Solrød',
    'Sønderborg',
    'Sorø',
    'Stevns',
    'Struer',
    'Svendborg',
    'Syddjurs',
    'Tårnby',
    'Thisted',
    'Tønder',
    'Vallensbæk',
    'Varde',
    'Vejen',
    'Vejle',
    'Vesthimmerlands',
    'Viborg',
    'Vordingborg',
  ];

  private array $dvfMembers = [
    'Aarhus',
  ];

  /**
   *
   */
  protected function createTerm(string $name, int $weight, ?Term $parent = NULL) {
    /** @var \Drupal\taxonomy\Entity\TermInterface $term */
    $term = parent::createTerm($name, $weight, $parent);

    if (in_array($term->getName(), $this->dvfMembers)) {
      $term->set('field_medlem_af_dvf', TRUE);
      $term->save();
    }

    return $term;
  }

}
