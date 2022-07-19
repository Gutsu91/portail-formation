const urlApi = 'http://localhost/Formation/API'
const connectForm = document.querySelector('.connectForm')
const login = document.querySelector('.login')
const pwd = document.querySelector('.password')

connectForm.addEventListener('submit', e => {
  e.preventDefault()
  let letsConnect = {
    email: login.value,
    password: pwd.value
  }
  fetch(urlApi + '/auth/', {
    header: {'Content-Type' : 'applicaton/json'},
    method: 'POST',
    body: JSON.stringify(letsConnect)
  })
  .then(response=> response.json())
  .then(response => {
    console.log(response)
    /* Si response code = 200 alors: 
    - mettre token, id user, type user dans session storage
    - faire un switch sur le type_user pour rediriger 
    - mettre un message de statut
    */
   if (response.response['code'] == 200) {
    console.log('ca marche mon vieux marty')
    sessionStorage.setItem('token', response.data['token'])
    sessionStorage.setItem('id_user', response.data['id_user'])
    sessionStorage.setItem('type_user', response.data['type_user'])
    switch(response.data['type_user']) {
      // à ajouter dans le switch si on a le temps: mettre un message de succes et rediriger après un setTimeOut
      case 'stagiaire':
        window.location.href = './gestion-evaluation.html'
        break
      default:
        window.location.href = './inscrire-stagiaire.html'
    }
   }
  })
  .catch(error => console.log(error))
})

/* gestion de la déconnexion
pas MVP
*/