const baseUrl = 'http://127.0.0.1:8000/api';

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

export function auth() {
    return {
        loginUser,
        registerUser
    }
}