const baseUrl = 'http://127.0.0.1:8000/api';

const deleteData = async (id, slug) => {
    await fetch(`${baseUrl}/${slug}/${id}/delete`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(id)
    });
};

export function del() {
    return {
        deleteData
    }
}