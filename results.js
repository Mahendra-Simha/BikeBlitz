// // results.js

// document.addEventListener('DOMContentLoaded', () => {
//     // Get the pincode from the URL query parameters
//     const urlParams = new URLSearchParams(window.location.search);
//     const pincode = urlParams.get('pincode');

//     // Display the pincode
//     document.getElementById('pincode-display').textContent = `Pincode: ${pincode}`;

//     // Lookup place name based on pincode
//     const placeName = lookupPlace(pincode);
//     if (placeName === "Unknown Place") {
//         // Display a message if pincode does not exist
//         document.getElementById('place-display').textContent = "Sorry, we couldn't find any place for this pincode.";
//         document.getElementById('place-display').style.color = "#dc3545"; // Set color to indicate error
//     } else {
//         document.getElementById('place-display').textContent = `Place: ${placeName}`;
//         document.getElementById('place-display').style.color = "#28a745"; // Set color for valid place
//     }
// });

// function lookupPlace(pincode) {
//     // Dummy data for place names
//     var placeNames = {
//         "583131": "Harapanahalli",
//         "123456": "Sample Place",
//         "583104": "Bellary",
//         "560001": "Banglore",
//         // Add more pincode-place mappings here
//     };

//     return placeNames[pincode] || "Unknown Place";
// }
