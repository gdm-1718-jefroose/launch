import router from '../router';
import axios from 'axios';

// URL and endpoint constants
const API_URL = 'http://localhost/'
const LOGIN_URL = API_URL + 'user/login?_format=hal_json'
const SIGNUP_URL = API_URL + 'user/register?_format=hal_json'

export default {

  // User object will let us check authentication status
  user: {
    authenticated: false,
    name: ''
  },

  login(context, params, redirect){
    axios
      .post(LOGIN_URL, params)
      .then((response) => {
        context.success = 'Login Successful';
        context.error = '';

        localStorage.setItem('username', response.data.current_user.name);
        localStorage.setItem('uid', response.data.current_user.uid);
        localStorage.setItem('csrf_token', response.data.csrf_token);
        localStorage.setItem('logout_token',response.data.logout_token);
        localStorage.setItem('auth', window.btoa(this.name + ':' + this.password));

        this.user.authenticated = true;
        this.user.name = localStorage.getItem('username')
        
        if(redirect) {
          router.push(redirect)        
        }

      })
      .catch((error)=>{
        var errorResponse = error.response.data.message;
        errorResponse = errorResponse.replace(/(?:\r\n|\r|\n)/g, '<br />');

        context.success = '';
        context.error = errorResponse;
      })
  },

  signup(context, params, redirect){
    axios
      .post(SIGNUP_URL, params, {
        'Accept' : 'application/hal+json',
        'Content-Type' : 'application/hal+json',
        'X-CSRF-Token' : 'TXM82YpXeTff3HJcGFvL6vKKmvzh-JilKuSrDmLrAS8'   
      })
      .then((response)=>{
        context.success = 'Registration successful';
        context.error = '';

        if(redirect) {
          router.push(redirect)        
        }
      })
      .catch((error) => {
        var errorResponse = error.response.data.message;
        errorResponse = errorResponse.replace(/(?:\r\n|\r|\n)/g, '<br />');
        
        context.success = '';
        context.error = errorResponse;
      })
  },

  logout(){
    localStorage.removeItem('username');
    localStorage.removeItem('uid');
    localStorage.removeItem('csrf_token');
    localStorage.removeItem('logout_token');
    localStorage.removeItem('auth');

    this.user.authenticated = false;
    this.user.name = ''  
  },

  checkAuth() {
    var jwt = localStorage.getItem('auth')
    if(jwt) {
      this.user.authenticated = true,
      this.user.name = localStorage.getItem('username')
    }
    else {
      this.user.authenticated = false,
      this.user.name = ''  
    }
  },

  getUserHeader() {
    return {
      'Authorization': localStorage.getItem('auth')
    }
  }
}