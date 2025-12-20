import { auth } from "./auth";

const baseUrl = 'http://127.0.0.1:8000/api';
const { refreshUser } = auth();

const updateUser = async (data, slug, id) => {
    const response = await fetch(`${baseUrl}/${slug}/${id}/update`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: data
    });
    if (!response.ok) {
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }
    await refreshUser();
};

export function update() {
    return {
        updateUser
    }
}