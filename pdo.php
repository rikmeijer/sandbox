<?php
//$pdo = new PDO("mysql:dbname=wcl_test;host=localhost;", "root", "root");
$pdo = new PDO("mysql:dbname=webconnect_leden_test;host=localhost;", "root", "root");

$statement = $pdo->prepare("SELECT * FROM _users WHERE id=9999999999");

print_r($pdo->quote("test", PDO::PARAM_STR));

var_dump($statement->execute(), $statement->fetch(\PDO::FETCH_ASSOC));


$statement2 = $pdo->prepare('(SELECT 
  rel_persoon.inactief AS `inactief`,
  rel_persoon.geslacht AS `geslacht`,
  rel_persoon.titel_voor AS `titel_voor`,
  rel_persoon.titel_na AS `titel_na`,
  rel_persoon.voorletters AS `voorletters`,
  rel_persoon.voornamen AS `voornamen`,
  rel_persoon.roepnaam AS `roepnaam`,
  rel_persoon.tussenvoegsel AS `tussenvoegsel`,
  rel_persoon.achternaam AS `achternaam`,
  rel_persoon.website AS `website`,
  rel_persoon.geboortedatum AS `geboortedatum`,
  rel_persoon.geboorteplaats AS `geboorteplaats`,
  rel_persoon.geboorteland AS `geboorteland`,
  rel_persoon_dienstverband.voorkeur AS `dienstverband_voorkeur`,
  rel_bedrijf_id_rel_persoon_dienstverband.naam_bedrijf AS `dienstverband`,
  rel_persoon_adres.voorkeur AS `woonplaats_voorkeur`,
  rel_persoon_adres.plaats AS `woonplaats`,
  rel_persoon_email.voorkeur AS `emailadres_voorkeur`,
  rel_persoon_email.adres AS `emailadres`,
  rel_persoon_telefoon.voorkeur AS `telefoon_voorkeur`,
  rel_persoon_telefoon.nummer AS `telefoon`,
  rel_persoon.bank_nummer AS `bank_nummer`,
  rel_persoon.bank_naam AS `bank_naam`,
  rel_persoon.bank_iban AS `bank_iban`,
  rel_persoon.bank_bic AS `bank_bic`,
  rel_persoon.bsn AS `bsn`,
  rel_persoon.opmerking AS `opmerking`,
  rel_persoon._users_id AS `_users_id`,
  CONCAT(
    "{",
    CHAR(34),
    "inactief",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        "[",
        CHAR(34),
        rel_persoon.inactief,
        CHAR(34),
        ", {}]"
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "geslacht",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        "[",
        CHAR(34),
        rel_persoon.geslacht,
        CHAR(34),
        ", {}]"
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "titel_voor",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.titel_voor,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "titel_na",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.titel_na,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "voorletters",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.voorletters,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "voornamen",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.voornamen,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "roepnaam",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.roepnaam,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "tussenvoegsel",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.tussenvoegsel,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "achternaam",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.achternaam,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "website",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.website,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "geboortedatum",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.geboortedatum,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "geboorteplaats",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.geboorteplaats,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "geboorteland",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.geboorteland,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "dienstverband_voorkeur",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        "[",
        CHAR(34),
        rel_persoon_dienstverband.voorkeur,
        CHAR(34),
        ", {}]"
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "dienstverband",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_bedrijf_id_rel_persoon_dienstverband.naam_bedrijf,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "woonplaats_voorkeur",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        "[",
        CHAR(34),
        rel_persoon_adres.voorkeur,
        CHAR(34),
        ", {}]"
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "woonplaats",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon_adres.plaats,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "emailadres_voorkeur",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        "[",
        CHAR(34),
        rel_persoon_email.voorkeur,
        CHAR(34),
        ", {}]"
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "emailadres",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon_email.adres,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "telefoon_voorkeur",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        "[",
        CHAR(34),
        rel_persoon_telefoon.voorkeur,
        CHAR(34),
        ", {}]"
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "telefoon",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon_telefoon.nummer,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "bank_nummer",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.bank_nummer,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "bank_naam",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.bank_naam,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "bank_iban",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.bank_iban,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "bank_bic",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.bank_bic,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "bsn",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(CHAR(34), rel_persoon.bsn, CHAR(34)),
      "null"
    ),
    ",",
    CHAR(34),
    "opmerking",
    CHAR(34),
    ":",
    IFNULL(
      CONCAT(
        CHAR(34),
        rel_persoon.opmerking,
        CHAR(34)
      ),
      "null"
    ),
    ",",
    CHAR(34),
    "_users_id",
    CHAR(34),
    ":",
    IFNULL(rel_persoon._users_id, "null"),
    "}"
  ) AS `_object`,
  CONCAT(
    \'rel_persoon/\',
    `rel_persoon`._id
  ) AS `_id`,
  `rel_persoon`._deleted AS `_deleted` 
FROM
  rel_persoon 
  LEFT JOIN (
      (SELECT 
        rel_dienstverband.rel_persoon_id AS `rel_persoon_id`,
        rel_dienstverband.rel_bedrijf_id AS `rel_bedrijf_id`,
        rel_dienstverband.rel_dienstverband_soort_id AS `rel_dienstverband_soort_id`,
        rel_dienstverband.voorkeur AS `voorkeur`,
        rel_dienstverband.geldig_vanaf AS `geldig_vanaf`,
        rel_dienstverband.geldig_tot AS `geldig_tot`,
        rel_bedrijf_id_rel_dienstverband.naam_bedrijf AS `naam_bedrijf`,
        rel_bedrijf_id_rel_dienstverband.naam_intern AS `naam_intern`,
        rel_dienstverband.afdeling AS `afdeling`,
        rel_dienstverband.functie AS `functie`,
        CONCAT(
          "{",
          CHAR(34),
          "rel_persoon_id",
          CHAR(34),
          ":",
          IFNULL(
            rel_dienstverband.rel_persoon_id,
            "null"
          ),
          ",",
          CHAR(34),
          "rel_bedrijf_id",
          CHAR(34),
          ":",
          IFNULL(
            rel_dienstverband.rel_bedrijf_id,
            "null"
          ),
          ",",
          CHAR(34),
          "rel_dienstverband_soort_id",
          CHAR(34),
          ":",
          IFNULL(
            rel_dienstverband.rel_dienstverband_soort_id,
            "null"
          ),
          ",",
          CHAR(34),
          "voorkeur",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              "[",
              CHAR(34),
              rel_dienstverband.voorkeur,
              CHAR(34),
              ", {}]"
            ),
            "null"
          ),
          ",",
          CHAR(34),
          "geldig_vanaf",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              CHAR(34),
              rel_dienstverband.geldig_vanaf,
              CHAR(34)
            ),
            "null"
          ),
          ",",
          CHAR(34),
          "geldig_tot",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              CHAR(34),
              rel_dienstverband.geldig_tot,
              CHAR(34)
            ),
            "null"
          ),
          ",",
          CHAR(34),
          "naam_bedrijf",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              CHAR(34),
              rel_bedrijf_id_rel_dienstverband.naam_bedrijf,
              CHAR(34)
            ),
            "null"
          ),
          ",",
          CHAR(34),
          "naam_intern",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              CHAR(34),
              rel_bedrijf_id_rel_dienstverband.naam_intern,
              CHAR(34)
            ),
            "null"
          ),
          ",",
          CHAR(34),
          "afdeling",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              CHAR(34),
              rel_dienstverband.afdeling,
              CHAR(34)
            ),
            "null"
          ),
          ",",
          CHAR(34),
          "functie",
          CHAR(34),
          ":",
          IFNULL(
            CONCAT(
              CHAR(34),
              rel_dienstverband.functie,
              CHAR(34)
            ),
            "null"
          ),
          "}"
        ) AS `_object`,
        `rel_dienstverband`._deleted AS `_deleted` 
      FROM
        rel_dienstverband 
        INNER JOIN rel_bedrijf AS rel_bedrijf_id_rel_dienstverband 
          ON (
            rel_bedrijf_id_rel_dienstverband._id = rel_dienstverband.rel_bedrijf_id 
            AND rel_bedrijf_id_rel_dienstverband._deleted = 0
          )) AS rel_persoon_dienstverband 
  INNER JOIN rel_bedrijf AS rel_bedrijf_id_rel_persoon_dienstverband 
    ON (
      rel_bedrijf_id_rel_persoon_dienstverband._id = rel_persoon_dienstverband.rel_bedrijf_id 
      AND rel_bedrijf_id_rel_persoon_dienstverband._deleted = 0
    )
) 
ON (
  rel_persoon_dienstverband.rel_persoon_id = rel_persoon._id 
  AND rel_persoon_dienstverband._deleted = 0 
  AND rel_persoon_dienstverband.voorkeur = "ja"
) 
LEFT JOIN 
  (SELECT 
    rel_adres.rel_persoon_id AS `rel_persoon_id`,
    rel_adres.voorkeur AS `voorkeur`,
    rel_adres.geldig_vanaf AS `geldig_vanaf`,
    rel_adres.geldig_tot AS `geldig_tot`,
    rel_adres.rel_adres_soort_id AS `rel_adres_soort_id`,
    rel_adres_soort_id_rel_adres.koppeling_persoon AS `soort_type`,
    rel_adres_soort_id_rel_adres.naam AS `soort`,
    rel_adres.subadressering AS `subadressering`,
    rel_adres.straat AS `straat`,
    rel_adres.nummer AS `nummer`,
    rel_adres.toevoeging AS `toevoeging`,
    rel_adres.postcode AS `postcode`,
    rel_adres.plaats AS `plaats`,
    rel_adres.land AS `land`,
    CONCAT(
      "{",
      CHAR(34),
      "rel_persoon_id",
      CHAR(34),
      ":",
      IFNULL(
        rel_adres.rel_persoon_id,
        "null"
      ),
      ",",
      CHAR(34),
      "voorkeur",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          "[",
          CHAR(34),
          rel_adres.voorkeur,
          CHAR(34),
          ", {}]"
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "geldig_vanaf",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_adres.geldig_vanaf,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "geldig_tot",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_adres.geldig_tot,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "rel_adres_soort_id",
      CHAR(34),
      ":",
      IFNULL(
        rel_adres.rel_adres_soort_id,
        "null"
      ),
      ",",
      CHAR(34),
      "soort-type",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          "[",
          CHAR(34),
          rel_adres_soort_id_rel_adres.koppeling_persoon,
          CHAR(34),
          ", {}]"
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "soort",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_adres_soort_id_rel_adres.naam,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "subadressering",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_adres.subadressering,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "straat",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(CHAR(34), rel_adres.straat, CHAR(34)),
        "null"
      ),
      ",",
      CHAR(34),
      "nummer",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(CHAR(34), rel_adres.nummer, CHAR(34)),
        "null"
      ),
      ",",
      CHAR(34),
      "toevoeging",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_adres.toevoeging,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "postcode",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_adres.postcode,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "plaats",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(CHAR(34), rel_adres.plaats, CHAR(34)),
        "null"
      ),
      ",",
      CHAR(34),
      "land",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(CHAR(34), rel_adres.land, CHAR(34)),
        "null"
      ),
      "}"
    ) AS `_object`,
    `rel_adres`._deleted AS `_deleted` 
  FROM
    rel_adres 
    INNER JOIN rel_adres_soort AS rel_adres_soort_id_rel_adres 
      ON (
        rel_adres_soort_id_rel_adres._id = rel_adres.rel_adres_soort_id 
        AND rel_adres_soort_id_rel_adres._deleted = 0 
        AND rel_adres_soort_id_rel_adres.koppeling_persoon = "ja"
      )) AS rel_persoon_adres 
  ON (
    rel_persoon_adres.rel_persoon_id = rel_persoon._id 
    AND rel_persoon_adres._deleted = 0 
    AND rel_persoon_adres.voorkeur = "ja"
  ) 
LEFT JOIN 
  (SELECT 
    rel_email.rel_persoon_id AS `rel_persoon_id`,
    rel_email.voorkeur AS `voorkeur`,
    rel_email.geldig_vanaf AS `geldig_vanaf`,
    rel_email.geldig_tot AS `geldig_tot`,
    rel_email.rel_email_soort_id AS `rel_email_soort_id`,
    rel_email_soort_id_rel_email.koppeling_persoon AS `soort_type`,
    rel_email_soort_id_rel_email.naam AS `soort`,
    rel_email.adres AS `adres`,
    CONCAT(
      "{",
      CHAR(34),
      "rel_persoon_id",
      CHAR(34),
      ":",
      IFNULL(
        rel_email.rel_persoon_id,
        "null"
      ),
      ",",
      CHAR(34),
      "voorkeur",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          "[",
          CHAR(34),
          rel_email.voorkeur,
          CHAR(34),
          ", {}]"
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "geldig_vanaf",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_email.geldig_vanaf,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "geldig_tot",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_email.geldig_tot,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "rel_email_soort_id",
      CHAR(34),
      ":",
      IFNULL(
        rel_email.rel_email_soort_id,
        "null"
      ),
      ",",
      CHAR(34),
      "soort-type",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          "[",
          CHAR(34),
          rel_email_soort_id_rel_email.koppeling_persoon,
          CHAR(34),
          ", {}]"
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "soort",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_email_soort_id_rel_email.naam,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "adres",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(CHAR(34), rel_email.adres, CHAR(34)),
        "null"
      ),
      "}"
    ) AS `_object`,
    `rel_email`._deleted AS `_deleted` 
  FROM
    rel_email 
    INNER JOIN rel_email_soort AS rel_email_soort_id_rel_email 
      ON (
        rel_email_soort_id_rel_email._id = rel_email.rel_email_soort_id 
        AND rel_email_soort_id_rel_email._deleted = 0 
        AND rel_email_soort_id_rel_email.koppeling_persoon = "ja"
      )) AS rel_persoon_email 
  ON (
    rel_persoon_email.rel_persoon_id = rel_persoon._id 
    AND rel_persoon_email._deleted = 0 
    AND rel_persoon_email.voorkeur = "ja"
  ) 
LEFT JOIN 
  (SELECT 
    rel_telefoon.rel_persoon_id AS `rel_persoon_id`,
    rel_telefoon.voorkeur AS `voorkeur`,
    rel_telefoon.geldig_vanaf AS `geldig_vanaf`,
    rel_telefoon.geldig_tot AS `geldig_tot`,
    rel_telefoon.rel_telefoon_soort_id AS `rel_telefoon_soort_id`,
    rel_telefoon_soort_id_rel_telefoon.koppeling_persoon AS `soort_type`,
    rel_telefoon_soort_id_rel_telefoon.naam AS `soort`,
    rel_telefoon.nummer AS `nummer`,
    CONCAT(
      "{",
      CHAR(34),
      "rel_persoon_id",
      CHAR(34),
      ":",
      IFNULL(
        rel_telefoon.rel_persoon_id,
        "null"
      ),
      ",",
      CHAR(34),
      "voorkeur",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          "[",
          CHAR(34),
          rel_telefoon.voorkeur,
          CHAR(34),
          ", {}]"
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "geldig_vanaf",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_telefoon.geldig_vanaf,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "geldig_tot",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_telefoon.geldig_tot,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "rel_telefoon_soort_id",
      CHAR(34),
      ":",
      IFNULL(
        rel_telefoon.rel_telefoon_soort_id,
        "null"
      ),
      ",",
      CHAR(34),
      "soort-type",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          "[",
          CHAR(34),
          rel_telefoon_soort_id_rel_telefoon.koppeling_persoon,
          CHAR(34),
          ", {}]"
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "soort",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_telefoon_soort_id_rel_telefoon.naam,
          CHAR(34)
        ),
        "null"
      ),
      ",",
      CHAR(34),
      "nummer",
      CHAR(34),
      ":",
      IFNULL(
        CONCAT(
          CHAR(34),
          rel_telefoon.nummer,
          CHAR(34)
        ),
        "null"
      ),
      "}"
    ) AS `_object`,
    `rel_telefoon`._deleted AS `_deleted` 
  FROM
    rel_telefoon 
    INNER JOIN rel_telefoon_soort AS rel_telefoon_soort_id_rel_telefoon 
      ON (
        rel_telefoon_soort_id_rel_telefoon._id = rel_telefoon.rel_telefoon_soort_id 
        AND rel_telefoon_soort_id_rel_telefoon._deleted = 0 
        AND rel_telefoon_soort_id_rel_telefoon.koppeling_persoon = "ja"
      )) AS rel_persoon_telefoon 
  ON (
    rel_persoon_telefoon.rel_persoon_id = rel_persoon._id 
    AND rel_persoon_telefoon._deleted = 0 
    AND rel_persoon_telefoon.voorkeur = "ja"
  )) LIMIT :INTERNAL_OFFSET, :INTERNAL_LIMIT');
 
$statement2->bindValue(":INTERNAL_LIMIT", 0, \PDO::PARAM_INT);
$statement2->bindValue(":INTERNAL_OFFSET", 100, \PDO::PARAM_INT);
$statement2->execute();

var_Dump($statement2->rowCount());