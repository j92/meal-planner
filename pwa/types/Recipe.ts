export class Recipe {
  public "@id"?: string;

  constructor(
    _id?: string,
    public name?: string,
    public sourceUrl?: string,
  ) {
    this["@id"] = _id;
  }
}
