import { NextComponentType, NextPageContext } from "next";
import { Show } from "../../../components/recipe/Show";
import { Recipe } from "../../../types/Recipe";
import { fetch } from "../../../utils/dataAccess";

interface Props {
  recipe: Recipe;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({ recipe }) => {
  return <Show recipe={recipe} />;
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const recipe = await fetch(asPath);

  return { recipe };
};

export default Page;
