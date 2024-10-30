document.addEventListener('DOMContentLoaded', function() {

    const decisions = document.querySelectorAll(".decision");
    const classeSuperieures = document.querySelectorAll(".nextClassroom");
    const motifs = document.querySelectorAll(".motif");
    

    decisions.forEach(function(decision, index){
        
        function miseAjourBordures(element,valid) {
            element.style.border = valid ? '2px solid green' : '2px solid red';
        }

        function miseAjourFormulaire() {
            const decisionValue = decision.value;
            var classeSuperieure = classeSuperieures[index];
            var motif = motifs[index];

    
            if (decisionValue === "1") {
                classeSuperieure.style.display = '';
                classeSuperieure.required = true;
                classeSuperieure.classList.add('required-field', 'vibrate');
                // classeSuperieure.style.borderColor = 'red';
                miseAjourBordures(classeSuperieure, false);

    
                motif.style.display = 'none';
                motif.required = false;
            }
            else if (decisionValue === '3' || decisionValue === '7') {
                motif.style.display = '';
                motif.required = true;
                motif.classList.add('required-field', 'vibrate');
                motif.style.borderColor = 'red';

                miseAjourBordures(motif, false);
    
                classeSuperieure.style.display = 'none';
                classeSuperieure.required = false;
            }
            else
            {
                classeSuperieure.style.display = 'none';
                classeSuperieure.required = false;
                motif.style.display = 'none';
                motif.required = false;
            }

            classeSuperieure.addEventListener('change', function() {
                miseAjourBordures(classeSuperieure, classeSuperieure.value !== '');
            });

            motif.addEventListener('input', function() {
                miseAjourBordures(motif, motif.value !== '');
            });
        }
    
        ///
        decision.addEventListener('change', miseAjourFormulaire);
    
        ///j'appelle lors du chargement de la page pour régler l'état initial
        miseAjourFormulaire();

      
    });

    
    
});
