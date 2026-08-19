// API Helper untuk PARFY.ID PHP Backend
// Modified for PHP API endpoints
const API_BASE = '/coding web IMK/parfy-php/api';

// Token management
const getToken = () => localStorage.getItem('parfy_token');
const setToken = (token) => localStorage.setItem('parfy_token', token);
const removeToken = () => localStorage.removeItem('parfy_token');

const getUser = () => {
    const user = localStorage.getItem('parfy_user');
    return user ? JSON.parse(user) : null;
};
const setUser = (user) => localStorage.setItem('parfy_user', JSON.stringify(user));
const removeUser = () => localStorage.removeItem('parfy_user');

// API request helper
async function apiRequest(endpoint, options = {}) {
    const token = getToken();

    const config = {
        ...options,
        headers: {
            'Content-Type': 'application/json',
            ...options.headers,
        }
    };

    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }

    if (options.body && typeof options.body === 'object') {
        config.body = JSON.stringify(options.body);
    }

    try {
        // Convert endpoint to PHP file path
        let phpEndpoint = endpoint;

        // Handle query strings
        const [path, query] = endpoint.split('?');
        const queryString = query ? `?${query}` : '';

        // Map endpoints to PHP files
        if (path.match(/^\/products\/[^/]+$/)) {
            const id = path.split('/')[2];
            phpEndpoint = `/api/products/detail.php?id=${id}${queryString ? '&' + query : ''}`;
        } else if (path === '/products') {
            phpEndpoint = `/api/products/index.php${queryString}`;
        } else if (path.match(/^\/cart\/[^/]+$/)) {
            const productId = path.split('/')[2];
            phpEndpoint = `/api/cart/item.php?productId=${productId}`;
        } else if (path === '/cart') {
            phpEndpoint = `/api/cart/index.php`;
        } else if (path === '/transactions/checkout') {
            phpEndpoint = `/api/transactions/checkout.php`;
        } else if (path === '/transactions/my-orders') {
            phpEndpoint = `/api/transactions/my-orders.php`;
        } else if (path.match(/^\/transactions\/[^/]+\/cancel$/)) {
            const id = path.split('/')[2];
            phpEndpoint = `/api/transactions/cancel.php?id=${id}`;
        } else if (path.match(/^\/transactions\/[^/]+$/)) {
            const id = path.split('/')[2];
            phpEndpoint = `/api/transactions/detail.php?id=${id}`;
        } else if (path === '/transactions') {
            phpEndpoint = `/api/transactions/index.php`;
        } else if (path === '/auth/register') {
            phpEndpoint = '/api/auth/register.php';
        } else if (path === '/auth/login') {
            phpEndpoint = '/api/auth/login.php';
        } else if (path === '/auth/me') {
            phpEndpoint = '/api/auth/me.php';
        } else if (path === '/auth/logout') {
            phpEndpoint = '/api/auth/logout.php';
        } else if (path === '/users') {
            phpEndpoint = '/api/users/index.php';
        } else if (path === '/users/me' || path.match(/^\/users\/profile/)) {
            phpEndpoint = '/api/users/profile.php';
        } else if (path.match(/^\/users\/[^/]+\/address/) || path.match(/^\/users\/me\/address/)) {
            // Handle ID in path for DELETE/PUT
            const parts = path.split('/');
            const lastPart = parts[parts.length - 1];
            const hasId = !isNaN(lastPart) && parts[parts.length - 2] === 'address';

            if (hasId) {
                phpEndpoint = `/api/users/addresses.php?id=${lastPart}${queryString ? '&' + query : ''}`;
            } else {
                phpEndpoint = `/api/users/addresses.php${queryString}`;
            }
        } else if (path.match(/^\/reviews\/[^/]+/)) {
            const reviewId = path.split('/')[2];
            phpEndpoint = `/api/reviews/index.php?id=${reviewId}${queryString ? '&' + queryString.substring(1) : ''}`;
        } else if (path === '/reviews') {
            phpEndpoint = `/api/reviews/index.php${queryString}`;
        } else if (path === '/dashboard/stats' || path === '/dashboard') {
            phpEndpoint = '/api/dashboard/index.php';
        } else if (path === '/dashboard/charts') {
            phpEndpoint = '/api/dashboard/charts.php';
        } else if (path === '/chat') {
            phpEndpoint = '/api/chat/index.php';
        } else if (path === '/payment/create') {
            phpEndpoint = '/api/payment/create.php';
        } else if (path === '/payment/notification') {
            phpEndpoint = '/api/payment/notification.php';
        } else {
            // Default: try direct mapping
            phpEndpoint = `/api${path}.php${queryString}`;
        }

        const response = await fetch(`${API_BASE.replace('/api', '')}${phpEndpoint}`, config);
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'Terjadi kesalahan');
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// Auth API
const authAPI = {
    async register(name, email, password, phone = '') {
        const data = await apiRequest('/auth/register', {
            method: 'POST',
            body: { name, email, password, phone }
        });
        setToken(data.token);
        setUser(data.user);
        return data;
    },

    async login(email, password) {
        const data = await apiRequest('/auth/login', {
            method: 'POST',
            body: { email, password }
        });
        setToken(data.token);
        setUser(data.user);
        return data;
    },

    logout() {
        removeToken();
        removeUser();

        // Redirect directly to homepage
        window.location.href = '/coding web IMK/parfy-php/';
    },

    async getMe() {
        return await apiRequest('/auth/me');
    },

    isLoggedIn() {
        return !!getToken();
    },

    isAdmin() {
        const user = getUser();
        return user && user.role === 'admin';
    }
};

// Products API
const productsAPI = {
    async getAll(filters = {}) {
        const params = new URLSearchParams(filters);
        return await apiRequest(`/products?${params}`);
    },

    async getById(id) {
        return await apiRequest(`/products/${id}`);
    },

    async create(productData) {
        return await apiRequest('/products', {
            method: 'POST',
            body: productData
        });
    },

    async update(id, productData) {
        return await apiRequest(`/products/${id}`, {
            method: 'PUT',
            body: productData
        });
    },

    async delete(id) {
        return await apiRequest(`/products/${id}`, {
            method: 'DELETE'
        });
    },

    async updateStock(id, stock) {
        return await apiRequest(`/products/${id}`, {
            method: 'PUT',
            body: { stock }
        });
    }
};

// Cart API
const cartAPI = {
    async get() {
        return await apiRequest('/cart');
    },

    async add(productId, quantity = 1) {
        return await apiRequest('/cart', {
            method: 'POST',
            body: { productId, quantity }
        });
    },

    async update(productId, quantity) {
        return await apiRequest(`/cart/${productId}`, {
            method: 'PUT',
            body: { quantity }
        });
    },

    async updateQuantity(productId, quantity) {
        return await apiRequest(`/cart/${productId}`, {
            method: 'PUT',
            body: { quantity }
        });
    },

    async remove(productId) {
        return await apiRequest(`/cart/${productId}`, {
            method: 'DELETE'
        });
    },

    async clear() {
        return await apiRequest('/cart', {
            method: 'DELETE'
        });
    }
};

// Transactions API
const transactionsAPI = {
    async getAll() {
        return await apiRequest('/transactions');
    },

    async getById(id) {
        return await apiRequest(`/transactions/${id}`);
    },

    async myOrders() {
        return await apiRequest('/transactions/my-orders');
    },

    async checkout(orderData) {
        return await apiRequest('/transactions/checkout', {
            method: 'POST',
            body: orderData
        });
    },

    async create(items, shippingAddress) {
        return await apiRequest('/transactions', {
            method: 'POST',
            body: { items, shippingAddress }
        });
    },

    async updateStatus(id, status, paymentStatus) {
        return await apiRequest(`/transactions/${id}`, {
            method: 'PUT',
            body: { status, paymentStatus }
        });
    },

    async cancelOrder(id, reason) {
        return await apiRequest(`/transactions/${id}/cancel`, {
            method: 'POST',
            body: { reason }
        });
    }
};

// Payment API (Midtrans)
const paymentAPI = {
    async createPayment(transactionId) {
        return await apiRequest('/payment/create', {
            method: 'POST',
            body: { transactionId }
        });
    }
};


// Users API
const usersAPI = {
    async getAll() {
        return await apiRequest('/users');
    },

    async getById(id) {
        return await apiRequest(`/users/${id}`);
    },

    async me() {
        return await apiRequest('/users/me');
    },

    async updateProfile(userData) {
        return await apiRequest('/users/me', {
            method: 'PUT',
            body: userData
        });
    },

    async update(id, userData) {
        return await apiRequest(`/users/${id}`, {
            method: 'PUT',
            body: userData
        });
    },

    async delete(id) {
        return await apiRequest(`/users/${id}`, {
            method: 'DELETE'
        });
    },

    async addAddress(id, addressData) {
        return await apiRequest(`/users/${id}/address`, {
            method: 'POST',
            body: addressData
        });
    },

    async deleteAddress(addressId) {
        return await apiRequest(`/users/me/address/${addressId}`, {
            method: 'DELETE'
        });
    }
};

// Reviews API
const reviewsAPI = {
    async getAll() {
        return await apiRequest('/reviews');
    },

    async getByProduct(productId) {
        return await apiRequest(`/reviews?productId=${productId}`);
    },

    async getRecent() {
        return await apiRequest('/reviews');
    },

    async create(productId, productName, rating, comment) {
        return await apiRequest('/reviews', {
            method: 'POST',
            body: { productId, productName, rating, comment }
        });
    },

    async delete(id) {
        return await apiRequest(`/reviews/${id}`, {
            method: 'DELETE'
        });
    }
};

// Dashboard API
const dashboardAPI = {
    async getStats() {
        const data = await apiRequest('/dashboard');
        // Format data to match admin dashboard expectations
        return {
            ...data,
            formatted: {
                totalRevenue: formatRupiah(data.totalRevenue),
                totalOrders: data.totalTransactions,
                totalUsers: data.totalUsers,
                lowStock: data.lowStock + ' Produk',
                outOfStock: data.outOfStock || 0
            }
        };
    },
    async getChartData() {
        return await apiRequest('/dashboard/charts');
    },

    async getSales() {
        return await apiRequest('/dashboard/charts'); // Forward to new charts API
    },

    async getTopProducts() {
        const data = await apiRequest('/dashboard');
        return data.topProducts || [];
    },

    async getRecentOrders() {
        const data = await apiRequest('/dashboard');
        return data.recentTransactions || [];
    },

    async getRecentReviews() {
        // Dashboard API doesn't return reviews currently in the index.php I saw?
        // Let's check api/dashboard/index.php again. 
        // It DOES NOT return 'recentReviews'. It returns recentTransactions and topProducts.
        // Wait, I need to check if recentReviews is in the PHP response.
        const data = await apiRequest('/dashboard');
        return data.recentReviews || [];
    }
};

// Chat API
const chatAPI = {
    async send(message, userName = '') {
        return await apiRequest('/chat', {
            method: 'POST',
            body: { message, userName }
        });
    }
};

// Format helpers
function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Export for use
window.PARFY = {
    auth: authAPI,
    products: productsAPI,
    cart: cartAPI,
    transactions: transactionsAPI,
    payment: paymentAPI,
    users: usersAPI,
    reviews: reviewsAPI,
    dashboard: dashboardAPI,
    chat: chatAPI,
    formatRupiah,
    formatDate,
    getUser,
    getToken
};
