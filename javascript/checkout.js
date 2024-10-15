function removeCartProductRequest(userid,productid){
    if(userid==0 || userid==null){
      //console.log("IM HERE!");
      document.getElementById("responsetext").innerHTML= "There is no user logged in! Please consider login in to perform this action!";
      return 0;
    }
    const data = {
      user_id: userid,
      product_id: productid
    };
    console.log(data);
    fetch('/php/remove_shopping_cart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data),
    })
    .then(response => {
      // Check if the response status is in the OK range (200-299)
      if (response.ok) {
        // Parse the JSON response
        return response.json();
      } else {
        // If the response status is not OK, throw an error
        throw new Error('Network response was not ok.');
      }
    })
    .then(data => {
      //console.log(data);
      //console.log(data.message)
      if (data.message === 'Already in cart!') {
        //console.log('Item already in the wish list!');
      } else if (data.message === 'Item added to shopping cart') {
        location.reload();
        //console.log('Item added to the wish list.'); 
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }

  function removeWishListProductRequest(userid,productid){
    if(userid==0 || userid==null){
      //console.log("IM HERE!");
      document.getElementById("responsetext").innerHTML= "There is no user logged in! Please consider login in to perform this action!";
      return 0;
    }
    const data = {
      user_id: userid,
      product_id: productid
    };
    console.log(data);
    fetch('/php/remove_wishlist.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data),
    })
    .then(response => {
      // Check if the response status is in the OK range (200-299)
      if (response.ok) {
        // Parse the JSON response
        return response.json();
      } else {
        // If the response status is not OK, throw an error
        throw new Error('Network response was not ok.');
      }
    })
    .then(data => {
      //console.log(data);
      //console.log(data.message)
      if (data.message === 'Already in cart!') {
        //console.log('Item already in the wish list!');
      } else if (data.message === 'Item added to shopping cart') {
        location.reload();
        //console.log('Item added to the wish list.'); 
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }