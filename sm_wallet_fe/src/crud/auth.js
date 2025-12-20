import { ref } from "vue";

const baseUrl = 'http://127.0.0.1:8000/api';

const isAuthenticated = ref(false);
const user = ref({});

function isLogged() {
    return isAuthenticated.value;
}

function getCurrentUser() {
    return user.value;
};

const refreshUser = async () => {
    user.value = await getUser();
};

const loginUser = async (dto) => {
    const response = await fetch(`${baseUrl}/login`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dto)
    });

    if (!response.ok) {
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }

    const data = await response.json();
    localStorage.setItem('token', data.token);
    isAuthenticated.value = !isAuthenticated.value;
    user.value = await getUser();
};


const registerUser = async (registerData) => {
    const response = await fetch(`${baseUrl}/register`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(registerData)
    });

    if (!response.ok) {
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }
};

const getUser = async () => {
    const response = await fetch(`${baseUrl}/user`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })

    if (response.ok) {
        return await response.json();
    }
};

const logoutUser = async () => {
    await fetch('http://localhost:8000/api/logout', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })
    localStorage.removeItem('token');
    isAuthenticated.value = !isAuthenticated.value;
    user.value = {};
};

export function auth() {
    return {
        loginUser,
        registerUser,
        logoutUser,
        isLogged,
        getCurrentUser,
        refreshUser
    }
}