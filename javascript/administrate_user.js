function banUserOnClick(button) {
    var username = button.closest('tr').querySelector('td:first-child').innerText;

    fetch('php/ban_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(username),
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(function(data) {
        let status = button.closest('tr').querySelector('.status');
        let buttonCell = button.closest('tr').querySelector('.buttons');
        buttonCell.innerHTML = '';
        status.innerHTML = '';

        let text = document.createElement('p');
        text.textContent = 'Banned';
        text.classList.add('row-info');
        status.appendChild(text);
    })
    .catch(function(error) {
        alert('An error occurred while banning user: ' + error.message); 
    });
}

function administrateUserOnClick(button) {
    var username = button.closest('tr').querySelector('td:first-child').innerText;

    fetch('php/administrate_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(username),
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(function(data) {
        let status = button.closest('tr').querySelector('.status');
        status.innerHTML = '';

        if (data === '1') {
            let text = document.createElement('p');
            text.textContent = 'Admin';
            text.classList.add('row-info');
            status.appendChild(text);

            button.classList.remove('promote-button');
            button.classList.add('demote-button');
            button.setAttribute('title', 'Demote User');
            button.querySelector('i').classList.remove('ri-arrow-up-circle-line');
            button.querySelector('i').classList.add('ri-arrow-down-circle-line');
        } else {
            let text = document.createElement('p');
            text.textContent = 'User';
            text.classList.add('row-info');
            status.appendChild(text);

            button.classList.remove('demote-button');
            button.classList.add('promote-button');
            button.setAttribute('title', 'Promote User');
            button.querySelector('i').classList.remove('ri-arrow-down-circle-line');
            button.querySelector('i').classList.add('ri-arrow-up-circle-line');
        }
    })
    .catch(function(error) {
        alert('An error occurred while promoting user: ' + error.message); 
    });
}