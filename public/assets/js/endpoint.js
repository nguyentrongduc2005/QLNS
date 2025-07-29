// api.js

const BASE_URL = "http://localhost:8888/QLDA/public";

export const API_ENDPOINTS = {
    local: `http://localhost:8888/QLDA/public`,
    login: `${BASE_URL}/api/login`,
    register: `${BASE_URL}/api/register`,
    logout: `${BASE_URL}/api/logout`,
    getUserInfo: `${BASE_URL}/api/info`,
    // Thêm các endpoint khác nếu có...
};

export default API_ENDPOINTS;

// endpoint.js
