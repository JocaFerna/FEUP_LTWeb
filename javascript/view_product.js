"use strict";
function addWishListProductRequest(userid,productid){
    if(userid==0 || userid==null){
      //console.log("IM HERE!");
      document.getElementById("responsetext").innerHTML= "There is no user logged in! Please consider login in to perform this action!";
      return 0;
    }
    const data = {
      user_id: userid,
      product_id: productid
    };
    fetch('/php/add_wishlist.php', {
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
      if (data.message === 'Already in wish list!') {
        document.getElementById("responsetext").innerHTML='Item already in the wish list!';
        //console.log('Item already in the wish list!');
      } else if (data.message === 'Item added to wish list') {
        document.getElementById("responsetext").innerHTML='Item added to the wish list!';
        //console.log('Item added to the wish list.'); 
      }
       else if(data.message === 'Product already Bought! '){
        document.getElementById("responsetext").innerHTML='Item was already bought!';
      }
    })
    .catch(error => {
      //console.log('error');
      document.getElementById("responsetext").innerHTML='Item not in the wish list!';
      console.error('Error:', error);
    });
  }

  function addCartProductRequest(userid,productid){
    if(userid==0 || userid==null){
      //console.log("IM HERE!");
      document.getElementById("responsetext").innerHTML= "There is no user logged in! Please consider login in to perform this action!";
      return 0;
    }
    const data = {
      user_id: userid,
      product_id: productid
    };
    fetch('/php/add_shopping_cart.php', {
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
        document.getElementById("responsetext").innerHTML='Item already in the Shopping Cart!';
        //console.log('Item already in the wish list!');
      } else if (data.message === 'Item added to shopping cart') {
        document.getElementById("responsetext").innerHTML='Item added to the Shopping Cart!';
        //console.log('Item added to the wish list.'); 
      }
      else if(data.message === 'Product already Bought! '){
        document.getElementById("responsetext").innerHTML='Item was already bought!';
      }
    })
    .catch(error => {
      //console.log('error');
      document.getElementById("responsetext").innerHTML='Item not in the cart';
      console.error('Error:', error);
    });
  }


  function createChat(userid, productid) {
    console.log(userid);
    if(userid==0 || userid==null){
      //console.log("IM HERE!");
      document.getElementById("responsetext").innerHTML= "There is no user logged in! Please consider login in to perform this action!";
      return 0;
    }
    const data = {
      user_id: userid,
      product_id: productid
    };
    fetch('/php/create_chat.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data),
    })
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Network response was not ok.');
      }
    })
    .then(data => {
      if (data.message === 'Chat created') {
        console.log('Chat created successfully');
        window.location.href = "../"+data.location;
      } else {
        console.log('Failed to create chat');
        window.location.href = "../"+data.location;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      window.location.href = "../"+data.location;
    });
  }