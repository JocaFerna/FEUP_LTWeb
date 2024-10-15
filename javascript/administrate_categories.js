
function deleteCategoryOnClick(button) {
    let categoryId = button.dataset.id;
    let type = button.id;

    fetch('php/administrate_category.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + encodeURIComponent(categoryId) + '&type=' + encodeURIComponent(type),
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .catch(function(error) {
        alert('An error occurred while deleting category: ' + error.message); 
    });

    button.closest('tr').remove();
}

function addCategory(button){
    let type = button.id;
    if(type == 'category'){
    document.getElementById("modal-category").style.display = "block";
    }
    else if(type == 'size'){
    document.getElementById("modal-size").style.display = "block";
    }
    else{
    document.getElementById("modal-condition").style.display = "block";
    }
}

function closeCategoryModal() {
    document.getElementById("modal-category").style.display = "none";
};

function closeSizeModal() {
    document.getElementById("modal-size").style.display = "none";
};

function closeConditionModal() {
    document.getElementById("modal-condition").style.display = "none";
};

function saveCategoryButton() {
    let categoryName = document.getElementById("categoryName").value;
    document.getElementById("categoryName").value = "";
    if (categoryName.trim().length > 0) {
        let type = 'Category';
        fetch('php/create_category.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'categoryName=' + encodeURIComponent(categoryName) +'&type=' + encodeURIComponent(type),
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(function(data) {
            let dataArray = data.split('.');
            let id = dataArray[0];
            let name = dataArray[1];
            
            if (data && id != undefined && name != undefined) {
                addCategoryToTable(id, name);
            }
            closeCategoryModal();
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
    } else {
        console.log('Input is empty');
    }
}

function addCategoryToTable(id, name) {
    let tableBody = document.getElementById('category-body');
    let lastRow = tableBody.lastElementChild;

    let newRow = document.createElement('tr');

    let nameCell = document.createElement('td');
    nameCell.textContent = name;
    nameCell.scope = "row";

    let actionCell = document.createElement('td');

    let deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.dataset.id = id;
    deleteButton.id = 'deleteCategory';
    deleteButton.title = 'Delete Category';
    deleteButton.onclick = function() {
        deleteCategoryOnClick(this);
    };
    let deleteIcon = document.createElement('i');
    deleteIcon.className = 'ri-prohibited-2-line';
    deleteButton.appendChild(deleteIcon);

    actionCell.appendChild(deleteButton);

    newRow.appendChild(nameCell);
    newRow.appendChild(actionCell);

    tableBody.insertBefore(newRow,lastRow);
}

function saveSizeButton(){
    let sizeName = document.getElementById("sizeName").value;
        document.getElementById("sizeName").value = "";
        if (sizeName.trim().length > 0) {
            let type = 'Size';
            fetch('php/create_category.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'categoryName=' + encodeURIComponent(sizeName) +'&type=' + encodeURIComponent(type),
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(function(data) {
                let dataArray = data.split('.');
                let id = dataArray[0];
                let name = dataArray[1];
            
                if (data && id != undefined && name != undefined) {
                    addSizeToTable(id, name);
                }
                closeSizeModal();
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        } else {
            console.log('Input is empty');
        }
    }

function addSizeToTable(id, name){
    let tableBody = document.getElementById('size-body');
    let lastRow = tableBody.lastElementChild;

    let newRow = document.createElement('tr');

    let nameCell = document.createElement('td');
    nameCell.textContent = name;
    nameCell.scope = "row";

    let actionCell = document.createElement('td');

    let deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.dataset.id = id;
    deleteButton.id = 'deleteCategory';
    deleteButton.title = 'Delete Category';
    deleteButton.onclick = function() {
        deleteCategoryOnClick(this);
    };
    let deleteIcon = document.createElement('i');
    deleteIcon.className = 'ri-prohibited-2-line';
    deleteButton.appendChild(deleteIcon);

    actionCell.appendChild(deleteButton);

    newRow.appendChild(nameCell);
    newRow.appendChild(actionCell);

    tableBody.insertBefore(newRow,lastRow);
}

function saveConditionButton() {
    let conditionName = document.getElementById("conditionName").value;
    document.getElementById("conditionName").value = "";
    if (conditionName.trim().length > 0) {
        let type = 'Condition';
        fetch('php/create_category.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'categoryName=' + encodeURIComponent(conditionName) +'&type=' + encodeURIComponent(type),
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(function(data) {
            let dataArray = data.split('.');
                let id = dataArray[0];
                let name = dataArray[1];
            
                if (data && id != undefined && name != undefined) {
                    addConditionToTable(id, name);
                }
                closeConditionModal();
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
    } else {
        console.log('Input is empty');
    }
}

function addConditionToTable(id, name){
    let tableBody = document.getElementById('condition-body');
    let lastRow = tableBody.lastElementChild;

    let newRow = document.createElement('tr');

    let nameCell = document.createElement('td');
    nameCell.textContent = name;
    nameCell.scope = "row";

    let actionCell = document.createElement('td');

    let deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.dataset.id = id;
    deleteButton.id = 'deleteCategory';
    deleteButton.title = 'Delete Category';
    deleteButton.onclick = function() {
        deleteCategoryOnClick(this);
    };
    let deleteIcon = document.createElement('i');
    deleteIcon.className = 'ri-prohibited-2-line';
    deleteButton.appendChild(deleteIcon);

    actionCell.appendChild(deleteButton);

    newRow.appendChild(nameCell);
    newRow.appendChild(actionCell);

    tableBody.insertBefore(newRow,lastRow);
}