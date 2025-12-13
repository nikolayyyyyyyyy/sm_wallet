const baseUrl = 'http://127.0.0.1:8000/api';

const getData = async (slug) => {
    const response = await fetch(`${baseUrl}/${slug}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    });

    return await response.json();
}

export function get() {
    return {
        getData
    }
}