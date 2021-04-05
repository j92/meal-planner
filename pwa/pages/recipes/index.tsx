import { NextComponentType, NextPageContext } from "next";
import { List } from "../../components/recipe/List";
import { PagedCollection } from "../../types/Collection";
import { Recipe } from "../../types/Recipe";
import { fetch } from "../../utils/dataAccess";

interface Props {
  collection: PagedCollection<Recipe>;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({
  collection}) => <List recipes={collection["hydra:member"]} />;

Page.getInitialProps = async () => {
  const collection = await fetch("/recipes");

  return { collection };
};

export default Page;
