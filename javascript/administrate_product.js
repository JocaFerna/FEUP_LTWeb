let productId;

function deleteProductOnClick(button) {
    let productId = button.dataset.id;

    fetch('php/delete_product.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + encodeURIComponent(productId),
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .catch(function(error) {
        alert('An error occurred while deleting product: ' + error.message); 
    });

    button.closest('tr').remove();
}

function EditButtonClick(button) {
    let editModal = document.getElementById("edit-modal");
    productId = button.dataset.id;

    editModal.style.display = "block";

    let row = button.closest('tr');
    let title = row.querySelector('.row-title').textContent.trim();
    let price = row.querySelector('.row-price').textContent.trim();
    let status = row.querySelector('.row-status').textContent.trim();
    let model = row.querySelector('.row-model').textContent.trim();
    let brand = row.querySelector('.row-brand').textContent.trim();

    document.getElementById("editTitle").value = title;
    document.getElementById("editPrice").value = price;
    document.getElementById("editStatus").value = status;
    document.getElementById("editModel").value = model;
    document.getElementById("editBrand").value = brand;

}

function CloseModal(){
    let editModal = document.getElementById("edit-modal");
    editModal.style.display = "none";
}

function SaveChanges(){

    let newTitle = document.getElementById("editTitle").value;
    let newPrice = document.getElementById("editPrice").value;
    let newStatus = document.getElementById("editStatus").value;
    let newModel = document.getElementById("editModel").value;
    let newBrand = document.getElementById("editBrand").value;


    fetch('php/edit_product.php',{
        method:'POST',
        headers: {
         'Content-Type': 'application/x-www-form-urlencoded',
     },
     body: 'id=' + encodeURIComponent(productId) +'&title=' + encodeURIComponent(newTitle) +'&price=' + encodeURIComponent(newPrice) +'&status=' + encodeURIComponent(newStatus) +'&model=' + encodeURIComponent(newModel)+'&brand=' + encodeURIComponent(newBrand), 
     })
     .then(function(response) {
         if (!response.ok) {
             throw new Error('Network response was not ok');
         }
         return response.text();
     })
     .then(function(){
        let row = document.querySelector(`button[data-id="${productId}"]`).closest('tr');
        row.querySelector('.row-title').textContent = newTitle;
        row.querySelector('.row-price').textContent = newPrice;
        row.querySelector('.row-status').textContent = newStatus;
        row.querySelector('.row-model').textContent = newModel;
        row.querySelector('.row-brand').textContent = newBrand;

        // Close the modal
        document.getElementById("edit-modal").style.display = "none";
     })
     .catch(function(error) {
         alert('An error occurred while banning user: ' + error.message); 
     });
};