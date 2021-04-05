// import App from "next/app";
import "../styles/global.css"
import type {AppProps /*, AppContext */} from "next/app";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import Layout from "../components/common/Layout";

function MyApp({Component, pageProps}: AppProps) {
    return <Layout>
        <Component {...pageProps} />
    </Layout>;
}

// Only uncomment this method if you have blocking data requirements for
// every single page in your application. This disables the ability to
// perform automatic static optimization, causing every page in your app to
// be server-side rendered.
//
// MyApp.getInitialProps = async (appContext: AppContext) => {
//   // calls page's `getInitialProps` and fills `appProps.pageProps`
//   const appProps = await App.getInitialProps(appContext);

//   return { ...appProps }
// }

export default MyApp;
