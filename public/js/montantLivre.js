document.addEventListener('DOMContentLoaded', function () {
    // Sélectionnez le champ "livre"
    let livreSelectors = Array.from(document.querySelectorAll('.livre-selector'));
    // console.log("Sélecteurs convertis en tableau : ", livreSelectors);
    
    livreSelectors.forEach(selector => 
    {console.log('Eléménts traité : ', selector);
    
        selector.addEventListener('change', function () 
        {   
            let selectedLivreId = this.value; // ID du livre sélectionné
            let montantField = this.closest('form').querySelector('.montant-field'); // Champ montant
            let baseUrl = this.getAttribute('data-url'); // URL pour récupérer le montant
            console.log(this.value);
            
            if (selectedLivreId && baseUrl) 
            {
                // j'effectue une requête AJAX pour récupérer le montant
                fetch(`${baseUrl}/${selectedLivreId}`)
                    .then(response => response.json())
                    .then(data => 
                    {
                        if (data.montant) 
                        {
                            montantField.value = data.montant; // Mettre à jour le champ montant
                        }
                    })
                    .catch(error => console.error('Erreur lors de la récupération du montant:', error));
            }
        });
    });
});
