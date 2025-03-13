const search = document.getElementById('search');

search.addEventListener("keydown", function(event){
    if(event.key === "Enter"){
        searchData();
    }
})

function searchData(){
    const page = search.getAttribute("data-page");
    window.location = page+'?search='+search.value;
}