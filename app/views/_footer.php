</body>
</html>
<script>
    function confirmDelete() {
        return confirm('Czy na pewno chcesz usunąć tę osobę?');
    }

    const buttons = document.querySelectorAll('.btn-delete');
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (!confirmDelete()) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            const row = e.target.closest('tr');
            const saveButton = row.querySelector('.btn-save');
            if (saveButton) {
                saveButton.classList.remove('disabled');
            }
        });
    });

    const saveButtons = document.querySelectorAll('.btn-save');
    

    function saveSubscription() {
        const row = event.target.closest('tr');
        const personId = row.querySelector('.subscription').dataset.person_id;
        const type = row.querySelector('input[type=radio]:checked').value;


        
        fetch('index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', 
            },
            body: new URLSearchParams({ // Formatowanie danych
                action: 'subscribe',
                personId: personId,
                type: type
            })
        }).then(response => {
            console.log(response);

            if (response.ok) {
                const button = row.querySelector('.btn-save');
                button.classList.add('disabled');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Wystąpił błąd podczas zapisywania subskrypcji');
        });
    }
</script>