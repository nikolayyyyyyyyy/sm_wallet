const baseUrl = 'http://127.0.0.1:8000/api';

const authenticate = async (dto, endpoint) => {
    const response = await fetch(`${baseUrl}/${endpoint}`, {
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

export function auth() {
    return {
        authenticate
    }
}