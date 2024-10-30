const decisions = document.querySelectorAll(".decision");
const nextClassrooms = document.querySelectorAll(".nextClassroom");
const motifs = document.querySelectorAll(".motif");

decisions.forEach(function(decision, index){
    
    decision.addEventListener("change", () => 
    {
        var nextClassroom = nextClassrooms[index];
        var motif = motifs[index];

        //// POUR LE CHAMP DECISION
        if (decision.value === "1")
        {
            //j'ajoute l'attribut 'required'dans la 2ème liste déroulante
            nextClassroom.required = true;
            nextClassroom.classList.add('required-field', 'vibrate');
            nextClassroom.style.borderColor = 'red';

            //je retire la classe 'vibrate' après l'animation pour permettre des vibrations répétées
            setTimeout(function(){
                nextClassroom.classList.remove('vibrate');
            }, 300);
        }
        else
        {
            //j'enlève le required dans la 2ème liste déroulante
            nextClassroom.required = false;
            nextClassroom.classList.remove('required-field');
            nextClassroom.style.borderColor = 'green';
        }

        //////////// POUR EXCLU ou EXCLU SI ECHEC
        if (decision.value === "3" || decision.value === "7")
        {
            //j'ajoute l'attribut 'required'dans la 2ème liste déroulante
            motif.required = true;
            motif.classList.add('required-field', 'vibrate');
            motif.style.borderColor = 'red';

            //je retire la classe 'vibrate' après l'animation pour permettre des vibrations répétées
            setTimeout(function(){
                motif.classList.remove('vibrate');
            }, 300);
        }
        else
        {
            //j'enlève le required dans la 2ème liste déroulante
            motif.required = false;
            motif.classList.remove('required-field');
            motif.style.borderColor = 'green';
        }

        //j'ajoute un écouteur d'événement 'change' à la 2ème liste déroulante
        nextClassroom.addEventListener('change', function()
        {
            if (nextClassroom.value)
            {
                //j'ajoite le bordure verte lorsque le 2ème liste est renseignée
                nextClassroom.classList.remove('required-field');
                nextClassroom.classList.add('filled-field');
            }
            else
            {
                //je rtire la bordure verte
                nextClassroom.classList.remove('filled-field');
                if(nextClassroom.required)
                {
                    nextClassroom.classList.add('required-field');
                }
            }
        });
    });

});
