const fournisseurs = document.getElementById('fournisseurs')
if(fournisseurs){
    fournisseurs.addEventListener('click',(e) => {
        if(e.target.className === 'btn btn-danger delete-fournisseur'){
            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');

                fetch(`/fournisseur/delete/${id}`,{
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }

        }
    });
}