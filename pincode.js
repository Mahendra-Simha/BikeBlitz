// // pincode.js

// function checkPincode() {
//     const pincode = document.getElementById('pincode').value.trim();
    
//     // Dummy data for place names; replace with actual data or API call
//     const placeNames = {
//         "583131": "Harapanahalli",
//         "123456": "Sample Place",
//         "583104":"Bellary",
//         // Add more pincode-place mappings here
//     };

//     if (pincode.length === 6 && !isNaN(pincode)) {
//         if (placeNames[pincode]) {
//             // Retrieve the place name based on pincode
//             const placeName = placeNames[pincode];
            
//             // Display success message with place name
//             document.getElementById('result').textContent = `Hooray, we got you! Service available in ${placeName}.`;
//             document.getElementById('result').style.color = "#28a745"; // Success color
            
//             // Redirect after a delay (e.g., 3 seconds)
//             setTimeout(() => {
//                 window.location.href = `module.html?pincode=${pincode}`;
//             }, 3000); // Delay in milliseconds (3000 ms = 3 seconds)
//         } else {
//             // Show error message if pincode does not match
//             document.getElementById('result').textContent = "Sorry, we couldn't find any information for this pincode.";
//             document.getElementById('result').style.color = "#dc3545"; // Error color
//         }
//     } else {
//         document.getElementById('result').textContent = "Please enter a valid 6-digit pincode.";
//         document.getElementById('result').style.color = "#dc3545"; // Error color
//     }
// }
