import {FunctionComponent} from "react";
import Link from "next/link";
import Head from "next/head";
import ReferenceLinks from "../../components/common/ReferenceLinks";
import {Recipe} from "../../types/Recipe";

interface Props {
    recipes: Recipe[];
}

export const List: FunctionComponent<Props> = ({recipes}) => (
    <div>
        <Head>
            <title>Recipe List</title>
            <meta property="og:title" content="Recipe List" key="title"/>
        </Head>
        <h1>Recipe List</h1>
        <Link href="/recipes/create">
            <a className="btn btn-primary">Create</a>
        </Link>
        <table className="table table-responsive table-striped table-hover">
            <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>sourceUrl</th>
                <th>createdAt</th>
                <th/>
            </tr>
            </thead>
            <tbody>
            {recipes &&
            recipes.length !== 0 &&
            recipes.map((recipe) => (
                <tr key={recipe["@id"]}>
                    <th scope="row">
                        <ReferenceLinks items={recipe["@id"]} type="recipe"/>
                    </th>
                    <td>{recipe["name"]}</td>
                    <td>{recipe["sourceUrl"]}</td>
                    <td>{recipe["createdAt"]}</td>
                    <td>
                        <ReferenceLinks
                            items={recipe["@id"]}
                            type="recipe"
                            useIcon={true}
                        />
                    </td>
                    <td>
                        <Link href={`${recipe["@id"]}/edit`}>
                            <a>
                                <i className="bi bi-pen" aria-hidden="true"/>
                                <span className="sr-only">Edit</span>
                            </a>
                        </Link>
                    </td>
                </tr>
            ))}
            </tbody>
        </table>
    </div>
);
