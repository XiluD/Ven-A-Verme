// Making a Custom Hook (it has to start with the word 'use')

import { useState, useEffect } from "react";

const useFetch = (url) => {
    const [data, setData] = useState(null);
    const [isPending, setIsPending] = useState(true);
    const [error, setError] = useState(null);
    /*
    
        When we are fetching some data, we know that this "fetch" always takes some time to do.
        So, the question is, what happen if we are loading and fetching some data to show in a view, and quickly we change to another view????
        What happen to that data that was being fetched? Did it complete? And where it goes?
        The actual result of that, is an error. And the error tells us:
        """
        Warning: Can't perform a React state update on an UNMOUNTED component. This is a no-op, but it indicates a memory leak in your application.
        To fix, cancel all subscriptions and asynchronous tasks in a useEffect cleanup function.
        Home@http://localhost:3000/static/js/main.chunk.js:511:64
        """
        So we can intuit that the fetch is still going on in the background once we've switched to the other view. And therefore when the fetch is
        complete it still tries to update the state in the home component, but the problem is, that the home component isn't anymore in the browser.

        Therefore, we need a way of stopping the fetch when the component using it unmounts.
        Now to do this, we'll be using a combination of a cleanup function in a use effect hook, and something called an AbortController from JavaScript.

        For the cleanup function, all we need to do, is place the cleanup function inside the useEffect Hook and return a value (that is a function), so 
        when the component that uses the useEffect or useFetch (our custom hook) it fires that returned cleanup function.
        So it's at this point that we actually want to stop the fetch that is going on in the background so that we dont try to update the state. And well
        to do that we're going to use what's known as AbortController. The AbortController represents a controller object that allows you to abort one or
        more Web requests as and when desired. And what we can do with this AbortController is associate it with a specific fetch request, and once is associated,
        we can then use that AbortController to stop the fetch. So the way we associate it with a fetch is by first of all, adding on a second argument in the fetch
        function (is like setting some extra options to the fetch) and then use the "signal" property that it has which will be set equal to our defined constant (that
        is equal to AbortController).
        So now that everything is setted, we can then use this know to stop that fetch (when the problem occurs), and we will do that inside our "cleanup function".
    
        */
    useEffect(() => {
        const abortCont = new AbortController();
        setTimeout(() => { //Simulating some delay in the fetch for this tutorial (eps24)
            fetch(url, { signal: abortCont.signal }).then(response => {
                /*
                    Throwing our own errors, so that if there is an error in the response, it doesnt continue to the next line of code (so we dont get a 'fake' error that pops from the next operation).
                    Remember that the fetch api only throws a 'real' reject when there is some kind of network error (not the case of an incorrect url/endpoint/resource)
                */
                if (!response.ok) {
                    throw new Error('cannot fetch the data'); //Throwing our own error. When we throw an error inside an asynchronous function, the promise returned is rejected (so we can catch it later on)
                }
                return response.json();
            }).then(data => {
                setData(data);
                setIsPending(false); //If the fetch is done, we are no longer have to be pending for the data.
                setError(null); //If we try to fetch the data again (or other data) so we get rid of the error message if it's successful.
            }).catch(err => {
                if(err.name === "AbortError"){ //Recognizing the abort error
                    console.log('fetch aborted');
                }
                else{
                    setError(err.message);
                    setIsPending(false);
                }
            });
        }, 0);

        /*

            Returning the "cleanup function". Which will abort whenever there is an "unexpected abort" (in our case a quick change of view when some data was getting fetch
            for the previous view), and pause it.
            The thing is, that when this fires, what it throws is an error.
            So to finalize, what we need to do, is recognize that error inside the catch error and control the error from there (so for example, we dont update the state/we
            dont try to output any error information to the previous view).

        */
        return () => abortCont.abort();

    }, [url]); // We set the url as a dependency, so whenever the url changes it's going to re-run this function to get the data for that endpoint.

    return { data, isPending, error } //We are going to return an object and place 3 values inside (its like returning a tuple)
}

export default useFetch //We need to export this function so we can use it in other components