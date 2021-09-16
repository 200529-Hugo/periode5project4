function updateColor() {
    var x = document.getElementById("color").value;
    document.getElementById("chip").style.backgroundColor = x;

    setTimeout(updateColor, 100);
}

updateColor()