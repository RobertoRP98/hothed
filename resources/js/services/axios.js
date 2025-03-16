// resources/js/services/axios.js

//AVISARLE QUE LARAVEL YA GENERO EL TOKEN
import axios from 'axios';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
//FINALIZA AVISO DE TOKEN

export default axios;
