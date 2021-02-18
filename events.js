//register the event
//first we are grabbing the button and listening for any click EventSource.
var searchButton = document.getElementById("search_text");
searchButton.addEventListener("input", fetch_data, false);

//TODO: add code to register the "input" event on the search text box so that
//it sends ajax requests whenever a key is pressed
//grab the input field not the button