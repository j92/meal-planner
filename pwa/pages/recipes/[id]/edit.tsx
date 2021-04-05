import { NextComponentType, NextPageContext } from "next";
import { Form } from "../../../components/recipe/Form";
import { Recipe } from "../../../types/Recipe";
import { fetch } from "../../../utils/dataAccess";

interface Props {
  recipe: Recipe;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({ recipe }) => {
  return <Form recipe={recipe} />;
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const recipe = await fetch(asPath.replace("/edit", ""));

  return { recipe };
};

export default Page;
