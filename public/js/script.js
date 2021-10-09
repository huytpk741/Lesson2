var navigation = document.getElementById("navigation");
var btn = navigation.getElementsByClassName("btn");

for (var i = 0; i < btn.length; i++) {
    btn[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
    });
}