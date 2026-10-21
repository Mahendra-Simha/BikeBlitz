function searchBikes() {
    // Get the search input value
    var input = document.getElementById('searchInput').value.toLowerCase();
    // Get all the bike boxes
    var boxes = document.getElementsByClassName('box');

    // Loop through the boxes and display/hide based on the search input
    for (var i = 0; i < boxes.length; i++) {
        var model = boxes[i].getElementsByTagName('h3')[0].innerText.toLowerCase();
        if (model.includes(input)) {
            boxes[i].style.display = '';
        } else {
            boxes[i].style.display = 'none';
        }
    }
}
