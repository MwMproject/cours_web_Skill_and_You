export interface SchoolFields {
  nom_etablissement?: string;
  adresse_1?: string;
  adresse_2?: string;
  code_postal?: string;
  libelle_commune?: string;
  type_etablissement?: string;
  statut_public_prive?: string;
  geo_point_2d?: [number, number];
}

export interface SchoolRecord {
  recordid: string;
  fields: SchoolFields;
}
