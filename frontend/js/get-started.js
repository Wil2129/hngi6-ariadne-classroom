var query = window.location.search;
var param = query.slice(1);
if (param === 'teacher') {
    document.getElementById("type").selectedIndex = "0";
} else if (param === 'student') {
    document.getElementById("type").selectedIndex = "1";
}