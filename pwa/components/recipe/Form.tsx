import {FunctionComponent, useState} from "react";
import Link from "next/link";
import {useRouter} from "next/router";
import Head from "next/head";
import * as Yup from 'yup';
import {ErrorMessage, Formik} from "formik";
import {fetch} from "../../utils/dataAccess";
import {Recipe} from "../../types/Recipe";

interface Props {
    recipe?: Recipe;
}

const CreateRecipeSchema = Yup.object().shape({
    name: Yup.string()
        .min(2, 'Too Short!')
        .max(255, 'Too Long!')
        .required('Required'),
    sourceUrl: Yup.string().url('Invalid URL'),
});

export const Form: FunctionComponent<Props> = ({recipe}) => {
    const [error, setError] = useState(null);
    const router = useRouter();

    const handleDelete = async () => {
        if (!window.confirm("Are you sure you want to delete this item?")) return;

        try {
            await fetch(recipe["@id"], {method: "DELETE"});
            router.push("/recipes");
        } catch (error) {
            setError(`Error when deleting the resource: ${error}`);
            console.error(error);
        }
    };

    return (
        <div>
            <div>
                <Head>
                    <title>
                        {recipe ? `Edit Recipe ${recipe["@id"]}` : `Create Recipe`}
                    </title>
                    <meta
                        property="og:title"
                        content={recipe ? `Edit Recipe ${recipe["@id"]}` : `Create Recipe`}
                    />
                </Head>
            </div>
            <h1>{recipe ? `Edit Recipe ${recipe["@id"]}` : `Create Recipe`}</h1>
            <Formik
                initialValues={recipe ? {...recipe} : new Recipe()}
                validationSchema={CreateRecipeSchema}
                onSubmit={async (values, {setSubmitting, setStatus, setErrors}) => {
                    console.log(values);
                    const isCreation = !values["@id"];
                    try {
                        await fetch(isCreation ? "/recipes" : values["@id"], {
                            method: isCreation ? "POST" : "PUT",
                            body: JSON.stringify(values),
                        });
                        setStatus({
                            isValid: true,
                            msg: `Element ${isCreation ? "created" : "updated"}.`,
                        });
                        router.push("/recipes");
                    } catch (error) {
                        setStatus({
                            isValid: false,
                            msg: `${error.defaultErrorMsg}`,
                        });
                        setErrors(error.fields);
                    }
                    setSubmitting(false);
                }}
            >
                {({
                      values,
                      status,
                      errors,
                      touched,
                      handleChange,
                      handleBlur,
                      handleSubmit,
                      isSubmitting,
                  }) => (
                    <form onSubmit={handleSubmit}>
                        <div className="form-group">
                            <label className="form-control-label" htmlFor="_name">
                                name
                            </label>
                            <input
                                name="name"
                                id="_name"
                                value={values.name ?? ""}
                                type="text"
                                placeholder=""
                                className={`form-control${
                                    errors.name && touched.name ? " is-invalid" : ""
                                }`}
                                aria-invalid={errors.name && touched.name}
                                onChange={handleChange}
                                onBlur={handleBlur}
                            />
                        </div>
                        <ErrorMessage className="text-danger" component="div" name="name"/>
                        <div className="form-group">
                            <label className="form-control-label" htmlFor="_sourceUrl">
                                sourceUrl
                            </label>
                            <input
                                name="sourceUrl"
                                id="_sourceUrl"
                                value={values.sourceUrl ?? ""}
                                type="text"
                                placeholder=""
                                className={`form-control${
                                    errors.sourceUrl && touched.sourceUrl ? " is-invalid" : ""
                                }`}
                                aria-invalid={errors.sourceUrl && touched.sourceUrl}
                                onChange={handleChange}
                                onBlur={handleBlur}
                            />
                        </div>
                        <ErrorMessage
                            className="text-danger"
                            component="div"
                            name="sourceUrl"
                        />
                        {status && status.msg && (
                            <div
                                className={`alert ${
                                    status.isValid ? "alert-success" : "alert-danger"
                                }`}
                                role="alert"
                            >
                                {status.msg}
                            </div>
                        )}

                        <button
                            type="submit"
                            className="btn btn-success"
                            disabled={isSubmitting}
                        >
                            Submit
                        </button>
                    </form>
                )}
            </Formik>
            <Link href="/recipes">
                <a className="btn btn-primary">Back to list</a>
            </Link>
            {recipe && (
                <button className="btn btn-danger" onClick={handleDelete}>
                    <a>Delete</a>
                </button>
            )}
        </div>
    );
};
