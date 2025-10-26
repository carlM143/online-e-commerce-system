<template>
  <div id="app">
    <!-- ✅ Navbar -->
    <header class="navbar">
      <div class="nav-left">
        <i class="fas fa-shopping-cart"></i>
        <router-link to="/" class="brand">Mini E-Commerce</router-link>
      </div>

      <div class="nav-right">
        <router-link to="/cart" class="cart-link">
          <i class="fas fa-shopping-cart"></i>
          <span v-if="cartCount > 0" class="cart-badge">{{ cartCount }}</span>
        </router-link>
      </div>
    </header>

    <!-- ✅ Page Content -->
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      cartCount: 0,
    }
  },
  mounted() {
    this.updateCartCount()
    window.addEventListener('storage', this.updateCartCount)
  },
  methods: {
    updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || []
      this.cartCount = cart.reduce((sum, item) => sum + item.quantity, 0)
    },
  },
}
</script>

<style scoped>
.navbar {
  background-color: #1e293b;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 35px;
  border-radius: 12px;
  margin: 20px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.nav-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.nav-left .brand {
  color: white;
  font-weight: bold;
  font-size: 1.3rem;
  text-decoration: none;
}

.nav-left .brand:hover {
  color: #60a5fa;
}

.nav-right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.cart-link, .login-link {
  position: relative;
  color: white;
  text-decoration: none;
  font-size: 1rem;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: color 0.3s;
}

.cart-link:hover, .login-link:hover {
  color: #3b82f6;
}

.cart-badge {
  position: absolute;
  top: -6px;
  right: -10px;
  background: #ef4444;
  color: white;
  border-radius: 50%;
  font-size: 0.7rem;
  padding: 3px 6px;
}
</style>
