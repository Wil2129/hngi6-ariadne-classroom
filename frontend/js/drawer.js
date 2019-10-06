fetch("frontend/drawer.html").then(response => {
    return response.text();
}).then(data => {
    document.querySelector(".drawer").innerHTML = data;
});