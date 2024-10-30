///pour sélectionner /déselectionner les élèves à cocher
document.getElementById('select-all').addEventListener('change', function(e) {
    let checkboxes = document.querySelectorAll('input[type="checkbox"][name="students[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = e.target.checked );
});

document.getElementById('select-al').addEventListener('change', function(e) {
    let checkboxes = document.querySelectorAll('input[type="checkbox"][name="students[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = e.target.checked );
});

//////////////////////////
document.getElementById('delete-students-form').addEventListener('submit', function(e) {
    //j'empêche soumission normale du formulaire
    e.preventDefault();

    let formData = new FormData(this);
    let xhr = new XMLHttpRequest();
    // xhr.open('POST', this.ariaDescription, true);
    // xhr.setRequestHeader('X-Request-With', 'XMLHttpRequest');
    // xhr.onload = function () {
    xhr.open('POST', '/delete-student-trash-selected', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){
        // if (xhr.status >= 200 && xhr.status < 400) {
        //     ///success
        //     notif({
        //         type: "success",
        //         msg: "<b>{% trans }Students selected delete successfully{% endtrans %}</b>",
        //         position: "center",
        //         width: 500,
        //         height: 60,
        //         autohide: true
        //     });

        //     /////Recherge de la page pour mettre à jour la liste
        //     location.reload();
        // }
        // else
        // {
        //     ///success
        //     notif({
        //         type: "error",
        //         msg: "<b>{% trans }Error{% endtrans %}</b>",
        //         position: "center",
        //         width: 500,
        //         height: 60,
        //         autohide: true
        //     });
        // }

        if (xhr.readyState === 4 && xhr.status === 200) 
            {
                var response = JSON.parse(xhr.responseText);
                if (response.success) 
                {
                    notif({
                        msg: "<b>{% trans }Students selected delete successfully{% endtrans %}</b>",
                        type: "success",
                        position: "left",
                        width: 500,
                        height: 60,
                        autohide: true
                        });

                }
                else 
                {
                    notif({
                        msg: "<b>{% trans %}Multiple delete error !{% endtrans %}</b>",
                        type: "danger",
                        position: "left",
                        width: 500,
                        height: 60,
                        autohide: true
                        });
                }
            }
    };

    console.log(formData);
    xhr.send(formData);
});