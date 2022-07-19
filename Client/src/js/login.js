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
  })
})