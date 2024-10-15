"use strict";
function send(SchoolId){	
    console.log(SchoolId);
	window.location.href = "products/product_view.php?product_id=" + SchoolId;
}