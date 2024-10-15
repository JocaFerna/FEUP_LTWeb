document.addEventListener("DOMContentLoaded", function(){
function loadContent(tabName) {
    fetch(tabName + '.php') 
        .then(response => response.text())
        .then(data => {
            document.getElementById('content-container').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}


document.getElementById('users-tab').addEventListener('click', function() {
    loadContent('admin_users_page');
});

document.getElementById('products-tab').addEventListener('click', function() {
    loadContent('admin_products_page');
});

document.getElementById('categories-tab').addEventListener('click', function() {
    loadContent('admin_categories_page');
});

// Load users page by default
loadContent('admin_users_page');
});

