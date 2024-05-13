window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
// Adicionando log para depuração
console.log('Configurando interceptors do Axios...');

window.axios.interceptors.request.use(
    config => {
        //definir para todas as requisições o header com o token
        config.headers.Accept = 'application/json';
        //recuperando o token de autorização dos cookies
        let token = document.cookie.split(';').find(x => x.includes('token='));
        token = token.split('=')[1];
        // Adicionando logs para depuração
        console.log('Interceptando o request antes do envio. Config:', config);
        console.log('Token recuperado dos cookies:', token);
        config.headers.Authorization = 'Bearer '+ token
        return config;
    },
    error => {
        console.log('Erro ao interceptar o request', error);
        return Promise.reject(error);
    }        
);

/* interceptar os reponses da aplicação */
window.axios.interceptors.response.use(
    response => {
        console.log('Interceptando a resposta antes do envio', response);
        return response;
    },
    error => {
        console.log('Erro na resposta', error.response);
        if(error.response.status == 401 && error.response.data.message == 'Unauthenticated.'){
            console.log('Fazer uma nova requisição para rota refresh');

            window.axios.post('/api/refresh')
                .then(response => {
                    console.log('Refresh com sucesso: ', response)

                    document.cookie = 'token='+response.data.access_token+';SameSite=Lax'
                    console.log('Novo token: ', response.data.access_token)
                    window.location.reload()
                })

        }
        return Promise.reject(error);
    }        
);

