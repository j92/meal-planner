import {FunctionComponent, useState} from "react";
import Link from "next/link";
import Head from "next/head";
import {useRouter} from "next/router";
import {fetch} from "../../utils/dataAccess";
import {Recipe} from "../../types/Recipe";
import Header from "../common/Header";

interface Props {
    recipe: Recipe;
}

export const Show: FunctionComponent<Props> = ({recipe}) => {
    const [error, setError] = useState(null);
    const router = useRouter();

    const handleDelete = async () => {
        if (!window.confirm("Are you sure you want to delete this item?")) return;

        try {
            await fetch(recipe["@id"], {method: "DELETE"});
            router.push("/recipes");
        } catch (error) {
            setError("Error when deleting the resource.");
            console.error(error);
        }
    };

    return (
        <div>
            <div>
                <Head>
                    <title>{`Show Recipe ${recipe["@id"]}`}</title>
                    <meta
                        property="og:title"
                        content={`Show Recipe ${recipe["@id"]}`}
                        key="title"
                    />
                </Head>
            </div>
            <h1>{`Show Recipe ${recipe["@id"]}`}</h1>
            <table className="table table-responsive table-striped table-hover">
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">name</th>
                    <td>{recipe["name"]}</td>
                </tr>
                <tr>
                    <th scope="row">sourceUrl</th>
                    <td>{recipe["sourceUrl"]}</td>
                </tr>
                <tr>
                    <th scope="row">createdAt</th>
                    <td>{recipe["createdAt"]}</td>
                </tr>
                </tbody>
            </table>
            {error && (
                <div className="alert alert-danger" role="alert">
                    {error}
                </div>
            )}
            <Link href="/recipes">
                <a className="btn btn-primary">Back to list</a>
            </Link>{" "}
            <Link href={`${recipe["@id"]}/edit`}>
                <a className="btn btn-warning">Edit</a>
            </Link>
            <button className="btn btn-danger" onClick={handleDelete}>
                <a>Delete</a>
            </button>
        </div>
    );
};
