import Ls from './ls'
import axios from 'axios'

export default {
  async login (loginData) {
    try {
      let response = await axios.post('/api/auth/login', loginData)
      Ls.set('auth.token', response.data.token)
      return response.data.token
    } catch (error) {
      if (error.response.status === 401) {
        //toastr['error']('Credenciales incorrectas', 'Error')
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message)
      }
    }
  },

  async logout () {
    try {
      await axios.get('/api/auth/logout')

      Ls.remove('auth.token')
      toastr['success']('Sesión finalizada', 'Éxito')
    } catch (error) {
      console.log('Error', error.message)
    }
  },

  async check () {
    let response = await axios.get('/api/auth/check')

    return !!response.data.authenticated
  }
}
